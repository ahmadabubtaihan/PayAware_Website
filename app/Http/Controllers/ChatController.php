<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Message;

class ChatController extends Controller
{
    /**
     * عرض قائمة المحادثات
     */
    public function index()
    {
        $userId = Auth::id();

        $conversations = User::where('id', '!=', $userId)
            ->where(function($q) use ($userId) {
                $q->whereHas('messagesSent', function($sq) use ($userId) {
                    $sq->where('receiver_id', $userId);
                })
                ->orWhereHas('messagesReceived', function($sq) use ($userId) {
                    $sq->where('sender_id', $userId);
                });
            })
            ->orWhereHas('debtsAsDebtor', function($q) use ($userId) {
                $q->where('creditor_id', $userId);
            })
            ->orWhereHas('debtsAsCreditor', function($q) use ($userId) {
                $q->where('debtor_id', $userId);
            })
            ->distinct()
            ->get();

        return view('chat.index', compact('conversations'));
    }

    /**
     * عرض رسائل محادثة محددة
     */
    public function show($id)
    {
        $userId = Auth::id();
        
        $activeUser = User::findOrFail($id);

        $conversations = User::where('id', '!=', $userId)
            ->where(function($q) use ($userId) {
                $q->whereHas('messagesSent', function($sq) use ($userId) {
                    $sq->where('receiver_id', $userId);
                })
                ->orWhereHas('messagesReceived', function($sq) use ($userId) {
                    $sq->where('sender_id', $userId);
                });
            })
            ->orWhereHas('debtsAsDebtor', function($q) use ($userId) {
                $q->where('creditor_id', $userId);
            })
            ->orWhereHas('debtsAsCreditor', function($q) use ($userId) {
                $q->where('debtor_id', $userId);
            })
            ->distinct()
            ->get();

        $messages = Message::where(function($q) use ($userId, $id) {
            $q->where('sender_id', $userId)->where('receiver_id', $id);
        })->orWhere(function($q) use ($userId, $id) {
            $q->where('sender_id', $id)->where('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc') 
        ->get();

        // تحديث الرسائل الواردة لتصبح "مقروءة"
        Message::where('sender_id', $id)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return view('chat.index', compact('conversations', 'activeUser', 'messages'));
    }

    /**
     * تخزين رسالة جديدة (نص أو ملف)
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000|required_without:attachment',
            'attachment' => 'nullable|file|max:10240|mimes:jpeg,png,jpg,gif,pdf,doc,docx,xls,xlsx',
        ]);

        $data = [
'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message ?? '', 
            'is_read' => false,        ];

        // معالجة الملف المرفق
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            
            $path = $file->store('attachments', 'public');
            
            $mimeType = $file->getMimeType();
            $type = str_starts_with($mimeType, 'image/') ? 'image' : 'document';

            $data['attachment_path'] = $path;
            $data['attachment_type'] = $type;
        }

        Message::create($data);

        return redirect()->route('chat.show', $request->receiver_id);
    }
}