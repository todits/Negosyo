<script setup>
import axios from 'axios';
import { ref, computed, onMounted, } from 'vue';


const props = defineProps({
    expenses: {
        type: Array,
        required: true
    },

    editing: {
        type: Boolean,
        required: true
    },
    selectedExpense: {
        type: Object,
        required: true
    }
})

const emit = defineEmits(['deleteExpense', 'batchList', 'edit'])




const handleClickEdit = (expenseselect) => {
    // props.expense.item = expenseselect.item
    // props.expense.price = expenseselect.price
    // props.expense.quantity = expenseselect.quantity
    // props.expense.total = expenseselect.total
    // props.expense.datepurchase = expenseselect.datepurchase
    // selectExpenses.value = expenseselect
    // update.value = true
    emit('edit', expenseselect)

}

// const total = computed(() => {
//     return expenses.value.total.reduce((acc, cur) => acc + cur, 0)
// })


const handleClickDelete = (expenseId) => {
    axios.delete(`api/expenses/${expenseId}`)
        .then(response => {
            emit('batchList')
        })
        .catch(error => {
            console.error(error);
        });
}


// const total = computed(() => {
//     return props.expenses.map(p => p.total)
// })

</script>

<template>
    <table class="table-auto border-2 p-0 text-black text-center border-spacing-y-px" style="width:1000px">
        <thead>
            <tr>
                <th class="w-96">Item</th>
                <th class="w-40">Quantity</th>
                <th class="w-40">Price</th>
                <th class="w-40">Total</th>
                <th class="w-40">Date Purchase</th>
            </tr>
        </thead>
        <tbody>
            <tr class="border-2" v-for="expense in props.expenses">
                <td>{{ expense.item }}</td>
                <td>{{ expense.quantity }}</td>
                <td>{{ expense.price }}</td>
                <td>{{ expense.total }}</td>
                <td>{{ expense.datepurchase }}</td>
                <td> <button @click="handleClickEdit(expense)">Edit</button></td>
                <td> <button @click="handleClickDelete(expense.id)">Delete</button></td>

            </tr>
            {{ total }}
        </tbody>
    </table>
</template>

<style scoped>
.table {
    display: flex;
    gap: 10px;
}
</style>