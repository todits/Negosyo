<script setup>
import { Link } from '@inertiajs/vue3';

const emit = defineEmits(['getbatch', 'batchDetails'])

const props = defineProps({
    batches: {
        type: Object,
        required: true
    }
})

const deleteBatch = (batchId) => {
    axios.delete(`api/batches/${batchId}`)
        .then(response => {
            emit('getbatch')
        })
        .catch(error => {
            console.error(error);
        });
}


</script>
<template>
    <table class="table-auto border-2 p-0 text-black text-center border-spacing-y-px" style="width:1000px">
        <thead>
            <tr>
                <th class="w-96">Batch No.</th>
                <th class="w-40">Cycle</th>
                <th class="w-40">Date Started</th>
                <th class="w-40">End Date</th>
                <th class="w-40">Info.</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-2" v-for="batch in props.batches">
                <td>{{ batch.batchNo }}</td>
                <td>{{ batch.cycle }}</td>
                <td>{{ batch.dateStarted }}</td>
                <td>{{ batch.endDate }}</td>
                <td>
                    <Link :href="`/batches/${batch.id}`">
                    Info
                    </Link>
                </td>

                <button type="submit" @click="deleteBatch(batch.id)"> delete</button>
            </tr>

        </tbody>
    </table>
</template>