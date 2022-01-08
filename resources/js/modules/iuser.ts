import {
ref,
// reactive,
// toRefs,
// readonly,
// computed
} from 'vue'

import axios from "axios";

let user_loading = ref(true);
let user_data = ref({});


const getUser = () => {

    // console.log('modules items getItemsAll', 1);

    if ( user_loading.value == true ) {

        console.log('modules user loading', 'start');


        //         // console.log( 'new_status' , new_status);
        axios
            .get(
                "/get-api/get_user"
            )
            .then(response => {
                console.log("getUser", response.data);
                // items_loading_module.value = items_now_loading.value;
                user_data.value = response.data.user;
                user_loading.value = false;
            })
            .catch(error => {
                console.log(error);
                // this.errored = true;
            });
        //         this.itemStatus0 = new_status;

    } else {
        console.log('modules user loading', 'no start');
    }

    // return user_data.value ?? {}

}

export default function iuser() {
    return {
        getUser,
        user_data,
        user_loading,
    };
}
