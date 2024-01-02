import { defineStore } from 'pinia';
import axios from 'axios';
import { onBeforeMount } from 'vue';

interface MessageState {
  threads: Object | null;
  thread: Object | null;
  receiver_id: string | Blob;
  active_room: string | Blob;
  alive: bool;
  receiver_data: Object | null;
  noMessage: bool;
  available: bool;
  broadcast: Object;
  timer: number | null;
}

export const useMessageStore = defineStore({
  id: 'message',

  state: (): MessageState => {
    return {
      threads: null,
      thread: null,
      receiver_id: null,
      active_room: null,
      alive: true,
      receiver_data: null,
      noMessage: true,
      available: false,
      broadcast: null,
      timer: null,
    };
  },

  getters: {
    getThreads: (state) => state.threads,
    getThread: (state) => state.thread,
  },

  actions: {
    async loadThreads() {
      const res = await axios.get('v1/message/threads');
      this.threads = res.data;
    },

    async loadThread(roomid: string, receiver_id: string) {
      const res = await axios.get('v1/message/thread/' + roomid);
      this.thread = res.data;
      this.receiver_id = receiver_id;
      this.active_room = roomid;
    },

    async sendMessage(messageData: Object) {
      const res = await axios.post('v1/message', messageData, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      if(this.receiver_data !== null)
      {
        this.loadThreads();
      }
      this.loadThread(res.data.data.room_id, res.data.data.receiver_id);
      this.receiver_data = null;
    },

    async loadBroadcast() {
      const res = await axios.get('v1/message/broadcast');
      this.broadcast = res.data;
    },

    async sendBroadcast(message, roles, attachments) {
    
      const res = await axios.post('v1/message/broadcast', {
        message: message.value,
        roles: roles.value,
        attachments: attachments,
      }, {
        headers: {
          'Content-Type': 'multipart/form-data',
        },
      });
      this.loadBroadcast();
      this.loadThreads();
    },

    async markAsRead(uuid: String) {
      const res = await axios.post('v1/message/read/' + uuid);
      this.loadThreads();
    },

    async alivecheck() {
      if(this.timer) clearTimeout(this.timer);
      this.timer = setTimeout( async() => {
        const res = await axios.get('v1/user/alive');
        if (res.data.success) {
            this.alive = res.data.success;
        }
        this.alivecheck();
      }, 120000);
    },

    // async updateReceiverData(data: Object) {
    //   this.receiver_data = null;
    //   this.receiver_id = null;
    //   this.available = false;
    //   this.loadThread(data.message_room_id, data.id);
    //   this.loadThreads().then(() => {
    //     this.threads?.data.some(thread => {
          
    //       if (thread.receiver_id === data.id) {
    //         this.available = true;
            
    //         return true;
    //       }
    //     });

    //     if(this.available === false) {
    //       this.receiver_data = data;
    //       this.receiver_id = data.id;
    //       this.available = true;
    //     }
    //     this.noMessage = false;
        
    //     this.router.push({ name: "inbox" });
    //   });
      
    // },

    async updateReceiverData(data: Object) {
      this.receiver_data = null;
      this.receiver_id = null;
      this.available = false;
      this.loadThread(data.message_room_id, data.id).then(() => {
        
        if(this.thread.data.length === 0) {
          this.receiver_data = data;
        }
        if(this.available === false) {
          this.receiver_id = data.id;
          this.available = true;
        }
        this.noMessage = false;
        
        this.router.push({ name: "inbox" });
      })
      
    }
  },

});