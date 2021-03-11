<template>

</template>
<script>
export default {
    name:'spelss',
    data(){
        return {
            ddata       : 0,
            show        : 0,
        }
    },
    computed:{
        equitment (){
            if (!this.ddata){
                this.$parent.getData('spells',this.checkResponse);
            }
            return this.ddata;
        },
    },
    methods:{
        checkResponse($data){
            this.ddata = $data;
            console.log($data);
        },
        updateParent(){
            this.$parent.scroll.showRight= 1;
            this.$parent.spells = this.selected;
            this.$parent.update('spells');
        },
    },
}
</script>
