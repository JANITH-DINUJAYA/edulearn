<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black text-gray-800 dark:text-white">Messages 💬</h2>
    </x-slot>

    <div x-data="messenger()" class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-[calc(100vh-200px)]">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl flex overflow-hidden h-full border dark:border-slate-700">

            <div class="w-1/3 border-r dark:border-slate-700 overflow-y-auto bg-slate-50/50 dark:bg-slate-900/20">
                <div class="p-5 border-b dark:border-slate-700">
                    <span class="font-black text-[10px] uppercase tracking-widest text-slate-400">Your Instructors</span>
                </div>

                <div class="divide-y dark:divide-slate-700">
                    @forelse($users as $user)
                    <div @click="selectUser({{ $user->id }}, '{{ $user->name }}')"
                         :class="selectedUser === {{ $user->id }} ? 'bg-indigo-50 dark:bg-indigo-900/20 border-r-4 border-indigo-600' : ''"
                         class="p-4 hover:bg-gray-100 dark:hover:bg-slate-700/50 cursor-pointer transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white font-bold text-xs shadow-lg shadow-indigo-100">
                                {{ substr($user->name, 0, 2) }}
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-sm dark:text-white">{{ $user->name }}</h4>
                                <p class="text-[10px] text-gray-500 uppercase font-black">Online Support</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center">
                        <p class="text-gray-400 text-sm italic">No conversations yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <div class="flex-1 flex flex-col bg-white dark:bg-slate-800">
                <template x-if="selectedUser">
                    <div class="flex flex-col h-full">
                        <div class="p-4 border-b dark:border-slate-700 flex items-center gap-3">
                            <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400 rounded-lg flex items-center justify-center text-xs font-bold" x-text="selectedUserName.substring(0,2)"></div>
                            <h3 class="font-bold dark:text-white" x-text="selectedUserName"></h3>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6 space-y-4 bg-slate-50/30 dark:bg-slate-900/10" id="message-container">
                            <template x-for="msg in messages" :key="msg.id">
                                <div :class="msg.sender_id === {{ auth()->id() }} ? 'justify-end' : 'justify-start'" class="flex">
                                    <div :class="msg.sender_id === {{ auth()->id() }} ? 'bg-indigo-600 text-white rounded-tr-none shadow-indigo-100' : 'bg-white dark:bg-slate-700 dark:text-white rounded-tl-none'"
                                         class="max-w-md p-3 rounded-2xl shadow-sm border dark:border-slate-600">
                                        <p class="text-sm whitespace-pre-wrap" x-text="msg.body"></p>
                                        <span class="text-[9px] opacity-70 mt-1 block text-right" x-text="formatDate(msg.created_at)"></span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <div class="p-4 border-t dark:border-slate-700">
                            <form @submit.prevent="sendMessage" class="flex gap-3">
                                <input x-model="newMessage" type="text" placeholder="Type a message to your instructor..."
                                       class="flex-1 bg-slate-100 dark:bg-slate-900 border-none rounded-2xl focus:ring-2 focus:ring-indigo-500 dark:text-white">
                                <button type="submit" :disabled="!newMessage.trim()" class="bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white px-6 py-2 rounded-2xl font-bold transition-all shadow-lg shadow-indigo-100">
                                    Send
                                </button>
                            </form>
                        </div>
                    </div>
                </template>

                <template x-if="!selectedUser">
                    <div class="flex-1 flex flex-col items-center justify-center p-12 text-center">
                        <div class="w-20 h-20 bg-indigo-50 dark:bg-indigo-900/20 rounded-full flex items-center justify-center mb-4 text-4xl">💬</div>
                        <h3 class="text-xl font-black dark:text-white">Instructor Chat</h3>
                        <p class="text-slate-500 max-w-xs mx-auto text-sm mt-2">Select an instructor to view your conversation or ask a question.</p>
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
                pollInterval: null,

                init() {
                    this.pollInterval = setInterval(() => {
                        if (this.selectedUser) this.fetchMessages(false);
                    }, 4000);
                },

                async selectUser(id, name) {
                    this.selectedUser = id;
                    this.selectedUserName = name;
                    this.messages = [];
                    await this.fetchMessages(true);
                },

                async fetchMessages(shouldScroll = true) {
                    try {
                        const response = await fetch(`/student/api/messages/${this.selectedUser}`);
                        const data = await response.json();
                        if (data.length !== this.messages.length) {
                            this.messages = data;
                            if (shouldScroll) this.scrollToBottom();
                        }
                    } catch (e) { console.error(e); }
                },

                async sendMessage() {
                    if (!this.newMessage.trim()) return;
                    try {
                        const response = await fetch('/student/api/messages', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                recipient_id: this.selectedUser,
                                body: this.newMessage
                            })
                        });
                        const saved = await response.json();
                        this.messages.push(saved);
                        this.newMessage = '';
                        this.scrollToBottom();
                    } catch (e) { console.error(e); }
                },

                formatDate(date) {
                    return new Date(date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                },

                scrollToBottom() {
                    this.$nextTick(() => {
                        const el = document.getElementById('message-container');
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                }
            }
        }
    </script>
</x-app-layout>
