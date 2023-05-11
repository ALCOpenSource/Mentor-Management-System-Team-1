import {defineStore} from 'pinia'
import axios from "axios"

interface supportState {
    ticket: Ticket | null;
}

interface Ticket {
    name: string;
    email: string;
    subject: string;
    message: array;
    attachement: array;
}

export const useSupportStore = defineStore({
    id: 'support',

    state: (): supportState => {
        return {
            ticket: null,
        }
    },

    getters:{
        getTicket: (state) => state.ticket,
    },

    actions: {

        async createTicket(ticketData: ticketData) {
          
            try {
              const response = await axios.post('v1/support', {
                name: ticketData.value.name,
                email: ticketData.value.email,
                subject: ticketData.value.title,
                message: ticketData.value.message,
              });
              if (response.data.success) {
                //this.ticket = response.data.data;
              }
              
              return response;
            } catch (error) {
              this.toaster.error(error.response.data.message);
              return error.response;
            }
          }
          
    }
})

interface ticketData {
    name: string;
    email: string;
    title: string;
    message: string;
}
