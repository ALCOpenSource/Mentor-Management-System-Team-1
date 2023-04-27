import {defineStore} from 'pinia'
import axios from "axios"

interface FaqState {
    faq: Faq | null;
}

interface Faq {
    general: General
}

interface General {
    id: number;
    question: string,
    answer: string,
    category: string,
    status: string,
    slug: string,
    meta_title: null,
    meta_description: null,
    meta_keywords: null,
    meta_robots: null,
    meta_canonical: null,
    meta_image: null

}
export const useFaqStore = defineStore({
    id: 'faq',

    state: (): FaqState => {
        return {
            faq: null,
        }
    },

    getters:{
        getFaq: (state) => state.gaq,
    },

    actions: {
        async setFaq() {
            const res = await axios.get('v1/faq')
            this.faq = res.data.data
        },
    }
})