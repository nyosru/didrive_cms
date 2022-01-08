import {
    ref,
    // watch,
    // reactive,
    // toRefs,
    // readonly,
    // computed
} from 'vue'


let showStatusDelete = ref(false);

export default function filterSettings() {
    return {
        showStatusDelete,
    };
}
