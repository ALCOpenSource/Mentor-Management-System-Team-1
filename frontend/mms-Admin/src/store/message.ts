import {defineStore} from 'pinia'
import axios from "axios"

interface MessageState {
    threads: object | null;
    thread: object | null;
    receiver_id: string | Blob;
}

export const useMessageStore = defineStore({
    id: 'message',

    state: (): MessageState => {
        return {
            threads: null,
            thread: null,
            receiver_id: null,
        }
    },

    getters:{
        getThreads: (state) => state.threads,
        getThread: (state) => state.thread,
    },

    actions: {
        async loadThreads() {
            const res = await axios.get('v1/message/threads')
            this.threads = res.data
        },

        async loadThread(roomid: string, receiver_id: string) {
            const res = await axios.get('v1/message/thread/' + roomid)
            this.thread = res.data
            this.receiver_id = receiver_id
        },

        async sendMessage(messageData: object) {

            console.log(this.receiver_id);
            const res = await axios.post('v1/message', messageData, {
                headers: {
                'Content-Type': 'multipart/form-data'
                }
            });
            this.loadThread(res.data.data.room_id, res.data.data.receiver_id)
            
        },

        async markAsRead(uuid: string) {
            const res = await axios.post('v1/message/read/' + uuid)
            this.loadThreads();
        },
    }
})