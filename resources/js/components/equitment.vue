<template>
    <section id="equitment" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Select Equipment</h2>
            </header>
            <div class="options-data-box">
                <div v-for="(item, index) in equitment" :key='index' class="options">
                    <h4>Choose {{item.choose - added[index] }}</h4>
                    <ul class="select-list">
                        <li v-for='(amount, name) in item.from' :key="name" v-on:click="select($event,index,name)">{{name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name:'equitment',
    data(){
        return {
            ddata       : 0,
            show        : 0,
            added       : [],
            selected    : [],
        }
    },
    computed:{
        equitment (){
            if (!this.ddata){
                this.$parent.getData('equitment',this.checkResponse);
            }
            return this.ddata;
        },
    },
    methods:{
        checkResponse($data){
            this.ddata = $data;
            $data.forEach(element => {
                this.added.push(0)
                this.selected.push([]);
            });
        },
        updateParent(){
            var x = 1,i;
            for(i=0;i<this.added.length;i++){
                if (this.added[i] != this.equitment[$index].choose){
                    x = 0;
                }
            }
            if (x){
                this.$parent.scroll.showRight= 1;
                this.$parent.equitment = this.selected;
                this.$parent.update('equitment');
            } else {
                this.$parent.equitment = 0;
                this.$parent.scroll.showRight= 0;
            }
        },
        select($element,$index,$name){
            let element = $element.target;
            if ( typeof this.added[$index] == 'undefined' ){
                this.added[$index] = 0;
            }
            if (element.classList.contains('select')){
                this.selected[$index] = this.removeFromArr(this.selected[$index],$name);
                element.classList.toggle('select');
                this.added[$index]--;
                this.updateParent();
            } else {
                if (this.added[$index] < this.equitment[$index].choose){
                    this.selected[$index].push($name);
                    element.classList.toggle('select');
                    this.added[$index]++
                    this.updateParent();
                }
            }
        },
        removeFromArr($arr,$item){
            var ret = [];
            for (let i = 0; i < $arr.length; i++) {
                const element = $arr[i];
                if (element != $item){
                    ret.push(element);
                }
            }
            return ret;
        }
    }

}
</script>
