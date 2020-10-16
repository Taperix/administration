<template>
    <app-layout>
        <template #header >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-3">
                Invoices
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="title" value="Title" />
                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                        <jet-input-error :message="form.error('title')" class="mt-2" />
                    </div>


                    <div class="col-span-6 sm:col-span-4 mt-2">
                        <jet-label for="items" value="Items" />
                        <invoice-item-selector :allItems="all_items" :selectedItems="items" v-on:itemsUpdated="updateItems"></invoice-item-selector>
                    </div>

                    <button v-on:click="create" class="p-3 px-6 bg-blue-300 text-white rounded-full mt-4 self-align-end">
                        Create
                    </button>
                    <span title="Last updated">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        {{last_updated}}
                    </span>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import Welcome from '../../Jetstream/Welcome'
    import JetButton from './../../Jetstream/Button'
    import JetFormSection from './../../Jetstream/FormSection'
    import JetInput from './../../Jetstream/Input'
    import JetInputError from './../../Jetstream/InputError'
    import JetLabel from './../../Jetstream/Label'
    import JetActionMessage from './../../Jetstream/ActionMessage'
    import JetSecondaryButton from './../../Jetstream/SecondaryButton'
    import invoiceItemSelector from '../../InvoiceItemSelector'

    export default {
        props: [
            'invoice',
            'last_updated',
            'items',
            'all_items'
        ],
        components: {
            AppLayout,
            Welcome,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
            invoiceItemSelector,
        },
        data() {
            return {
                form: this.$inertia.form({
                    title: this.invoice.title,
                    items: this.items,
                }, {
                    bag: 'createInvoice',
                    resetOnSuccess: false,
                }),
            }
        },
        methods: {
            updateItems(items) {
                this.form.items = items;
            },
            create() {
                this.form.put('/invoices/' + this.invoice.id, {
                    preserveScroll: true
                });
            }
        }
    }
</script>
