<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-6 sm:px-10 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
                        <div title="current balance" class="flex justify-center items-center pt-4">
                            <div class=" mr-4 text-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>                            </div>
                            <div class="flex items-center">
                                <currency-icon class="w-4 h-8 text-xl"
                                               :type="current_balance.currency"></currency-icon>
                                <div class="text-lg text-gray-600 leading-7 font-semibold">
                                    {{current_balance.value}}
                                </div>
                            </div>
                        </div>
                        <div title="outgoing invoices" class="flex justify-center items-center pt-4">
                            <div class=" mr-4 text-2xl" >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>                            </div>
                            <div class="flex items-center">
                                <currency-icon class="w-4 h-8 text-xl"
                                               :type="open_outgoing_invoices.currency"></currency-icon>
                                <div class="text-lg text-gray-600 leading-7 font-semibold">
                                    {{open_outgoing_invoices.value}}
                                </div>
                            </div>
                        </div>
                        <div title="incoming invoices" class="flex justify-center items-center pt-4">
                            <div class=" mr-4 text-2xl">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                            </div>
                            <div class="flex items-center">
                                <currency-icon class="w-4 h-8 text-xl"
                                               :type="open_incoming_invoices.currency"></currency-icon>
                                <div class="text-lg text-gray-600 leading-7 font-semibold">
                                    {{open_incoming_invoices.value}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../Layouts/AppLayout'
    import Welcome from './../Jetstream/Welcome'
    import JetApplicationLogo from './../Jetstream/ApplicationLogo'
    import currencyIcon from "../currencyIcon";

    export default {
        props: [
            'current_balance',
            'open_outgoing_invoices',
            'open_incoming_invoices',
        ],
        components: {
            AppLayout,
            Welcome,
            JetApplicationLogo,
            currencyIcon
        },
    }
</script>
