<script>
export default {
    emits: ["success"],
    props: {
        inventory: {
            type: Object
        },
        inventories: {
            type: Array
        }

    },
    data: function () {
        return {
            name: '',
            datePurchased: '',
            quantity: '',
            price: '',
            condition: '',
            selectedInventory: {},
            editing: false

        }
    },
    methods: {

        addItem() {
            if (this.editing) {
                axios.put(`/api/inventories/${this.selectedInventory.id}`, {
                    name: this.name,
                    datePurchased: this.datePurchased,
                    quantity: this.quantity,
                    price: this.price,
                    condition: this.condition,
                    total: this.total
                })
                    .then(response => {
                        this.editing = false
                        this.$emit('success', {
                            testing: 'Test',
                        })

                    })
                return
            }
            axios.post(`/api/inventories`, {
                name: this.name,
                datePurchased: this.datePurchased,
                quantity: this.quantity,
                price: this.price,
                total: this.total,
                condition: this.condition
            })
                .then(response => {
                    this.name = ''
                    this.datePurchased = ''
                    this.quantity = ''
                    this.price = ''
                    this.total = ''
                    this.condition = ''
                    this.$emit('success', { testing: 'Test' })
                })

        },
        edit(inventory) {
            this.name = inventory.name
            this.datePurchased = inventory.datePurchased
            this.quantity = inventory.quantity
            this.price = inventory.price
            this.condition = inventory.condition
            this.selectedInventory = inventory
            this.editing = true

        },
        deleteInventory(inventoryId) {
            axios.delete(`/api/inventories/${inventoryId}`)
                .then(response => {
                    this.name = ''
                    this.datePurchased = ''
                    this.quantity = ''
                    this.price = ''
                    this.total = ''
                    this.condition = ''
                    this.$emit('success', { testing: 'Test' })
                    this.editing = false
                })
                .catch(error => {
                    console.error(error);
                });
        }
    },
    computed: {
        total() {
            return this.quantity * this.price
        }
    }
}
</script>
<template>
    <form @submit.prevent="addItem">
        <table class="table-auto border-2 p-2 text-black" style="width:700px">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Date of Purchase</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Condition</th>
                    <th></th>
                </tr>
            </thead>

            <tbody>
                <tr class="">
                    <td><input type="text" v-model="name"></td>
                    <td><input type="date" v-model="datePurchased"></td>
                    <td><input type="number" v-model="quantity"></td>
                    <td><input type="number" v-model="price"></td>
                    <td><input type="number" disabled v-model="total"></td>
                    <td><input type="text" v-model="condition"></td>
                    <td><button type="submit">{{ editing ? 'Edit' : 'Submit' }}</button>

                    </td>

                </tr>
            </tbody>
        </table>
    </form>
    <div style=" display: flex; justify-content: center" class="flex justify-between">
        <table class=" table-auto border-2 p-2 text-black" style="width:700px">
            <thead>
                <tr>
                    <th></th>
                    <th>Item</th>
                    <th>Date of Purchase</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                    <th>Condition</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>

                <tr class="text-center" v-for="(inventory, index) in inventories">
                    <td>{{ index + 1 }}</td>
                    <td>{{ inventory.name }}</td>
                    <td>{{ inventory.datePurchased }}</td>
                    <td>{{ inventory.quantity }}</td>
                    <td>{{ inventory.price }}</td>
                    <td>{{ inventory.total }}</td>
                    <td>{{ inventory.condition }}</td>
                    <td><button type="submit" @click="edit(inventory)">Edit</button> |
                        <button type="submit" @click="deleteInventory(inventory.id)">Delete</button>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
</template>