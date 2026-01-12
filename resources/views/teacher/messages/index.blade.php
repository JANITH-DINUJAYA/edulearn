<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-bold text-gray-800 dark:text-white">Student Messages 💬</h2>
    </x-slot>

    <div x-data="messenger()" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[calc(100vh-200px)]">
        <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-lg flex overflow-hidden h-full border dark:border-slate-700">

            <div class="w-1/3 border-r dark:border-slate-700 overflow-y-auto bg-slate-50/50 dark:bg-slate-900/20">
                <div class="p-5 border-b dark:border-slate-700 flex justify-between items-center">
                    <span class="font-black text-xs uppercase tracking-widest text-slate-500">Recent Chats</span>
                </div>

                <div class="divide-y dark:divide-slate-700">
                    @foreach($users as $user)
                    <div @click="selectUser({{ $user->id }}, '{{ $user->name }}')"
                         :class="selectedUser === {{ $user->id }} ? 'bg-indigo-50 dark:bg-indigo-900/20 border-r-4 border-indigo-600' : ''"
                         class="p-4 hover:bg-gray-100 dark:hover:bg-slate-700/50 cursor-pointer transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-sm dark:text-white">{{ $user->name }}</h4>
                                <p class="text-xs text-gray-500 truncate">Click to reply</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="flex-1 flex flex-col bg-white dark:bg-slate-800">
                <template x-if="selectedUser">
                    <div class="flex flex-col h-full">
                        <div class="p-4 border-b dark:border-slate-700 flex items-center justify-between bg-white dark:bg-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-full flex items-center justify-center text-xs font-bold" x-text="selectedUserName.substring(0,2)"></div>
                                <h3 class="font-bold dark:text-white" x-text="selectedUserName"></h3>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30 dark:bg-slate-900/10" id="message-container">
                            <template x-for="msg in messages" :key="msg.id">
                                <div :class="msg.sender_id === {{ auth()->id() }} ? 'justify-end' : 'justify-start'" class="flex group">
                                    <div @click="setReply(msg)"
                                         :class="msg.sender_id === {{ auth()->id() }} ? 'bg-indigo-600 text-white rounded-tr-none' : 'bg-white dark:bg-slate-700 dark:text-white rounded-tl-none'"
                                         class="max-w-md p-3 rounded-2xl shadow-sm border dark:border-slate-600 cursor-pointer hover:brightness-95 transition-all relative">

                                        <p class="text-sm whitespace-pre-wrap" x-text="msg.body"></p>
                                        <span class="text-[9px] opacity-70 mt-1 block text-right" x-text="formatDate(msg.created_at)"></span>

                                        <div class="absolute -top-2 -right-2 hidden group-hover:flex bg-white dark:bg-slate-600 shadow-md rounded-full p-1">
                                            <svg class="w-3 h-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="p-4 border-t dark:border-slate-700">
                            <template x-if="replyingTo">
                                <div class="mb-3 p-2 bg-indigo-50 dark:bg-indigo-900/30 rounded-lg flex justify-between items-center border-l-4 border-indigo-500">
                                    <div class="truncate mr-4">
                                        <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase">Replying to:</span>
                                        <p class="text-xs text-gray-600 dark:text-gray-300 truncate italic" x-text="replyingTo.body"></p>
                                    </div>
                                    <button @click="replyingTo = null" class="text-gray-400 hover:text-red-500">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M6 18L18 6M6 6l12 12" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                                    </button>
                                </div>
                            </template>

                            <form @submit.prevent="sendMessage" class="flex gap-3">
                                <input x-model="newMessage" type="text" :placeholder="replyingTo ? 'Write your reply...' : 'Type your message...'"
                                       class="flex-1 bg-slate-100 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-indigo-500 dark:text-white">
                                <button type="submit" :disabled="!newMessage.trim()" class="bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white px-5 py-2 rounded-xl font-bold transition-all">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </template>

                <template x-if="!selectedUser">
                    <div class="flex-1 flex flex-col items-center justify-center">
                        <span class="text-6xl mb-4">📫</span>
                        <h3 class="text-xl font-bold dark:text-white">Student Inbox</h3>
                        <p class="text-slate-500">Select a student from the sidebar to start chatting.</p>
                    </div>
                </template>
            </div>
        </div>
    </div>

    <script>
        function messenger() {
            return {
                selectedUser: null,
                selectedUserName: '',
                newMessage: '',
                messages: [],
                replyingTo: null,
                pollInterval: null,

                init() {
                    // Check for new messages every 4 seconds
                    this.pollInterval = setInterval(() => {
                        if (this.selectedUser) {
                            this.fetchMessages(false);
                        }
                    }, 4000);
                },

                async selectUser(id, name) {
                    this.selectedUser = id;
                    this.selectedUserName = name;
                    this.messages = [];
                    this.replyingTo = null;
                    await this.fetchMessages(true);
                },

                setReply(msg) {
                    this.replyingTo = msg;
                    // Auto-focus input when clicking a message to reply
                    this.$nextTick(() => {
                        document.querySelector('input[x-model="newMessage"]').focus();
                    });
                },

                async fetchMessages(shouldScroll = true) {
                    try {
                        const response = await fetch(`/teacher/api/messages/${this.selectedUser}`);
                        const data = await response.json();

                        // Only update if message count changed (basic optimization)
                        if (data.length !== this.messages.length) {
                            this.messages = data;
                            if (shouldScroll) this.scrollToBottom();
                        }
                    } catch (error) {
                        console.error("Fetch Error:", error);
                    }
                },

                async sendMessage() {
                    if (this.newMessage.trim() === '') return;

                    // Formatting the body if it's a reply
                    let finalBody = this.newMessage;
                    if (this.replyingTo) {
                        finalBody = `Replying to: "${this.replyingTo.body}"\n---\n${this.newMessage}`;
                    }

                    try {
                        const response = await fetch('/teacher/api/messages', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                recipient_id: this.selectedUser,
                                body: finalBody
                            })
                        });

                        const savedMsg = await response.json();
                        this.messages.push(savedMsg);
                        this.newMessage = '';
                        this.replyingTo = null; // Clear reply state
                        this.scrollToBottom();
                    } catch (error) {
                        console.error("Send Error:", error);
                    }
                },

                formatDate(dateStr) {
                    if (!dateStr) return '';
                    return new Date(dateStr).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const container = document.getElementById('message-container');
                        if(container) {
                            container.scrollTop = container.scrollHeight;
                        }
                    });
                }
            }
        }
    </script>
</x-app-layout>
