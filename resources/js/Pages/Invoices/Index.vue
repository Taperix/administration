<template>
    <app-layout>
        <template #header >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-3">
                Invoices
            </h2>
            <a href="/invoices/create" class="p-3 px-6 bg-blue-300 text-white rounded-full">
                Create
            </a>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <tabs :options="{ useUrlFragment: true }">
                        <tab :name="ucfirst(state)" v-for="state in Object.keys(states)" :key="state">
                            <table>
                                <thead>
                                <tr>
                                    <th class="p-4">
                                        ID
                                    </th>
                                    <td class="p-4">
                                        titel
                                    </td>
                                    <td class="p-4">
                                        concept
                                    </td>
                                    <td class="p-4">
                                        actions
                                    </td>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="invoice in states[state]">
                                    <td class="p-4 py-1">{{invoice.id}}</td>
                                    <td class="p-4 py-1">{{invoice.title}}</td>
                                    <td class="p-4 py-1">{{invoice.state}}</td>
                                    <td class="p-4 py-1">
                                        <a :href="'/invoices/'+ invoice.id +'/pdf/preview'" class="p-1 px-2 bg-blue-300 text-white text-sm rounded-full">
                                            <i class="fa fa-eye"></i> view
                                        </a>
                                        <a :href="'invoices/' + invoice.id + '/edit'" class="ml-2 p-1 px-2 bg-green-300 text-white text-sm rounded-full">
                                            <i class="fa fa-pencil-square-o"></i> edit
                                        </a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </tab>
                    </tabs>
                </div>
            </div>
        </div>
    </app-layout>
</template>
<style>
    .tabs-component-tabs {
        display: flex;
        justify-content: center;
    }
    .tabs-component-tab {
        margin-right: 2rem;
    }
</style>
<script>
    import AppLayout from '../../Layouts/AppLayout'
    import Welcome from '../../Jetstream/Welcome'

    export default {
        props: [
            'states'
        ],
        components: {
            AppLayout,
            Welcome,
        },
    }
</script>
