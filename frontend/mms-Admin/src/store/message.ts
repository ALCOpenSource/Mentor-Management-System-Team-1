import {defineStore} from 'pinia'
import axios from "axios"

interface MessageState {
    threads: object | null;
    thread: object | null;
}

export const useMessageStore = defineStore({
    id: 'message',

    state: (): MessageState => {
        return {
            threads: null,
            thread: null,
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

        async loadThread(roomid: string) {
            const res = await axios.get('v1/message/thread/' + roomid)
            this.thread = res.data
            console.log(res.data);
        },
    }
})