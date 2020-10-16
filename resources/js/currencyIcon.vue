<template>
    <span class=" text-gray-400">
        {{icon}}
    </span>
</template>
<script>
    export default {
        props: ['type'],
        computed: {
            icon: function() {
                let icon = '';
                switch(this.type) {
                    case "EUR":
                        icon = '€';
                        break;
                    case "USD":
                        icon = "$";
                        break;
                    default:
                        icon = "CURRENCY NOT SPECIFIED";
                        console.warn('Currency not specified, please specify one (Examples : EUR, USD)');
                }

                return icon;
            }
        }
    }
</script>
