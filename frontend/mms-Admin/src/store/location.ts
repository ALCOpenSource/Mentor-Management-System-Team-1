import {defineStore} from 'pinia'
import axios from "axios"

interface LocationState {
    country: Country | null;
    state: State | null;
    city: City | null;
}

interface Country {
    id: number;
    name: string;
    code: string;
    capital: string;
    region: string;
    subregion: string;
    currency: string;
    currency_symbol: string;
    currency_code: string;
    phone_code: number;
    timezones: object;
    flag: string;
}

interface State {
    id: number;
    name: string;
    code: string;
}

interface City {
    id: number;
    name: string;
    code: string;
}

export const useLocationStore = defineStore({
    id: 'location',

    state: (): LocationState => {
        return {
            country: null,
            state: null,
            city: null,
        }
    },

    getters:{
        getCountry: (state) => state.country,
        getState: (state) => state.state,
        getCity: (state) => state.city,
    },

    actions: {
        async setCountry() {
            const res = await axios.get('v1/countries')
            this.country = res.data.data
        },

        async setState(code) {
            const res = await axios.get('v1/countries/'+code+'/state')
            this.state = res.data.data
        },

        async setCity(code) {
            const res = await axios.get('v1/countries/'+code+'/cities')
            this.city = res.data.data
        },
    }
})