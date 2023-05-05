<script setup>
import { onMounted, ref, computed, watch } from 'vue'
import { reactive } from 'vue';
import axios from 'axios';
import moment from 'moment'

const emit = defineEmits(['batch'])

const props = defineProps({
    lastItem: {
        type: Object,
        required: true
    },
    days: {
        type: String,
        required: true
    }
})


const batchNo = ref('')
const cycle = ref('')
const dateStarted = ref('')
const endDate = ref('')
const batches = ref([])
const getbatch = ref({})
const batch = ref({
    batchNo: '',
    cycle: '',
    dateStarted: '',
    endDate: ''

})


onMounted(() => {
    batchList()

})

const total = computed(() => {
    return batch.value.batchNo + batch.value.cycle
})

const lastItem = computed(() => {
    if (batches.value.length === 0) {

        return {}
    }
    emit('update')
    return batches.value[batches.value.length - 1]
})





console.log(lastItem)

const batchList = () => {
    axios.get('/api/batches')
        .then(response => {
            batches.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}


const endCycle = (update) => {
    axios.put(`/api/batches/${update}`, { endDate: endDate.value })
        .then(response => {
            console.log(response.data)
            endDate.value = response.data
            endDate.value = ''
            emit('update')


        })
        .catch(error => {
            console.log(error)
        })
}

</script>

<template>
    <div class="label">
        <div class="border">
            <p style="padding-right: 10px; font-weight: 600;">Current Batch: </p>
            <p>{{ props.lastItem.batchNo }}</p>
        </div>
        <div class="border">
            <p style="padding-right: 10px; font-weight: 600;">Current Cycle: </p>
            <p>{{ props.lastItem.cycle }}</p>
        </div>
        <div class="border">
            <p style="padding-right: 10px; font-weight: 600;">Date Started: </p>
            <p>{{ props.lastItem.dateStarted ? moment(props.lastItem.dateStarted).format('LL') : '' }}</p>
        </div>
        <div class="border" v-if="props.lastItem.endDate">
            <p style="padding-right: 10px; font-weight: 600;">End Date: </p>
            <p>{{ moment(props.lastItem.endDate).format('LL') }}</p>
        </div>
        <div class="border" v-if="props.lastItem.endDate">
            <p style="padding-right: 10px; font-weight: 600;">Days: </p>
            <p>{{ props.lastItem.totalDays }}</p>
        </div>
    </div>
</template>


<style scoped>
.label {
    display: flex;
    gap: 20px;

    padding: 10px;

}

.border {
    background: #d9d9f5;
    padding-left: 20px;
    border-radius: 6px;
    display: flex;
    width: 400px;
    font-size: 18px;
    height: 51px;
    place-items: center;
}
</style>