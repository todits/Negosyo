<script setup >
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';
import ExpensesTable from '@/Components/ExpensesTable.vue';


const batches = ref([])
const expense = ref({
    item: '',
    price: '',
    quantity: '',
    total: '',
    datepurchase: '',
})
const selectedExpense = ref({
})
const editing = ref(false)
const expenses = ref([])

onMounted(() => {
    getExpenses()
    batchList()
})

const batchList = () => {
    axios.get('/api/batches')
        .then(response => {
            batches.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}

const getExpenses = () => {
    axios.get(`/api/expenses`)
        .then(response => {
            console.log(response.data)
            expenses.value = response.data
        })
        .catch(error => {
            console.log(error)
        })
}
const handleClickSubmit = () => {
    if (editing.value) {
        axios.put(`/api/expenses/${selectedExpense.value.id}`, {
            item: expense.value.item,
            price: expense.value.price,
            quantity: expense.value.quantity,
            total: expense.value.total,
            datepurchase: expense.value.datepurchase,
        })
            .then(response => {
                expense.value.item = ''
                expense.value.price = ''
                expense.value.quantity = ''
                expense.value.total = ''
                expense.value.datepurchase = ''
                console.log(response.data)
                editing.value = false
                getExpenses()
                batchList()
            })
            .catch(error => {
                console.log(error)
            })
        return
    }
    axios.post(`/api/expenses`, {
        item: expense.value.item,
        price: expense.value.price,
        quantity: expense.value.quantity,
        total: expense.value.total,
        datepurchase: expense.value.datepurchase,
        batch_id: lastItem.value.id

    })
        .then(response => {
            expense.value.item = ''
            expense.value.price = ''
            expense.value.quantity = ''
            expense.value.total = ''
            expense.value.datepurchase = ''
            console.log(response.data)
            getExpenses()
            batchList()
        })
        .catch(error => {
            console.log(error)
        })

}

const lastItem = computed(() => {
    if (batches.value.length === 0) {
        return {}
    }
    return batches.value[batches.value.length - 1]
})

const totalExpenses = computed(() => {
    if (!lastItem.value) return 0
    if (!lastItem.value.hasOwnProperty('expenses')) return 0
    if (lastItem.value.expenses.length === 0) return 0

    return lastItem.value.expenses.reduce((total, expense) => total + expense.total, 0)
})

const edit = (payload) => {
    console.log(payload)
    selectedExpense.value = payload
    expense.value.item = payload.item
    expense.value.price = payload.price
    expense.value.quantity = payload.quantity
    expense.value.total = payload.total
    expense.value.datepurchase = payload.datepurchase
    editing.value = true
}

// const total = computed((acc, cur) => {
//     if (lastItem.value.expense === 0) {
//         return {}
//     }
//     lastItem.value.expense.total
//     return acc + cur.total;
// }, 0)
// const total = lastExpenses.expenses.reduce((acc, cur) => {
//     return acc + cur.total;
// }, 0)


</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Expenses</h2>
            <!-- <BatchInfo></BatchInfo> -->
            {{ total }}
            <div>
                <p>Current Batch: {{ lastItem.batchNo }} </p>
                <p>Current Cycle: {{ lastItem.cycle }} </p>
                <p>Date Started: {{ lastItem.dateStarted }}</p>
            </div>

        </template>
        {{ totalExpenses }}

        <div style="display: flex; gap: 10px;">
            <div>
                <form @submit.prevent="handleClickSubmit">
                    <div class="d-flex .flex-column input">
                        <InputLabel type="text" placeholder="Item" v-model="expense.item" :label="`Item`"
                            :required="true" />
                        <InputLabel type="text" placeholder="Price" v-model="expense.price" :label="`Price`"
                            :required="true" />
                        <InputLabel type="text" placeholder="Quantity" v-model="expense.quantity" :label="`Quantity`"
                            :required="true" />
                        <InputLabel type="text" placeholder="Total" v-model="expense.total" :label="`Total`"
                            :required="true" />
                        <label>Date of Purchase</label>
                        <input type="date" v-model="expense.datepurchase">
                        <button type="submit">{{ editing ? 'Update' : 'Submit' }}</button>
                    </div>
                </form>
            </div>
            <div>
                <ExpensesTable @batchList="batchList()" :selectedExpense="selectedExpense" :editing="editing"
                    :expenses="lastItem.expenses" @deleteExpense="getExpenses()" @edit="edit">
                </ExpensesTable>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style scoped>
.input {
    gap: 6px;
    display: flex;
    align-content: center;
    flex-direction: column;
    width: 100%;
    max-width: 400px;
    padding: 36px;
    margin: 22px;
}
</style>
