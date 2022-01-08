import
{
    ref,
    // reactive,
    // toRefs,
    // readonly,
    // computed
} from 'vue'

let now_page = ref(1);
let onPage = ref(20);
let kolvo = ref(0);


const setPage = (e) => {
    console.log('modules - pages - setPage', e);
    now_page.value = e;
}

export default function pages() {
    return {
        setPage,
        now_page,
        onPage,
        kolvo
    };
}
