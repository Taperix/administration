<template>
    <div>
        <div class="relative">
            <div class="absolute top-1px right-0 bottom-0">
                <button v-on:click="addItem" class="add-button  p-2 px-6 bg-blue-300 text-white">
                    Add
                </button>
            </div>
        </div>
        <select :readonly="readonly" v-model="current" name="items" id="items" class="form-input p-2 rounded-md shadow-sm mt-1 block w-full">
            <option v-for="item in allItems" :key="item.id" :value="item" class="p-2">
                {{item.text}}
            </option>
        </select>
        <ul class="pt-2">
            <li v-for="item in currentItems" :key="genRandomKey()" class="py-1">
                <button :readonly="readonly" v-on:click="removeItem(item)" class="add-button  p-2 px-6 bg-red-300 text-white">
                    Remove
                </button>
                <b>{{item.price.formatted}}</b>
                {{item.text}}
            </li>
        </ul>
    </div>
</template>
<style>
    .add-button {
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }
</style>
<script>
    export default {
        props: ['allItems', 'selectedItems', 'readonly'],
        methods: {
            addItem() {
                this.currentItems.push(this.current);
                this.$emit('itemsUpdated', this.currentItems);
            },
            removeItem(item) {
                this.currentItems.remove(item);
                this.$emit('itemsUpdated', this.currentItems);
            },
            makeRandom(length) {
                var result = '';
                var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                var charactersLength = characters.length;
                for (var i = 0; i < length; i++) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                }
                return result;
            },
            genRandomKey() {
                return this.makeRandom(5);
            }
        },
        mounted() {
            this.currentItems = this.selectedItems;
            this.$emit('itemsUpdated', this.currentItems);
        },
        data() {
            return {
                current: null,
                currentItems: [],
            }
        }
    }
</script>
