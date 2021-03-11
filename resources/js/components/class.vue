<template>
    <section id="class" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Pick A Class</h2>
            </header>
            <div class="options-data-box">
                <div class="options">
                    <ul class="select-list">
                        <li v-for="c in classes" :key="c.id" v-on:click="showClass=c.id; updateParent();"  :class="{select:showClass == c.id}" > {{ c.name }}  </li>
                    </ul>
                </div>
                <div class="data">
                    <div v-for="c in classes" :key="c.id"  >
                        <div class="info-box" v-if="showClass === c.id" >
                            <table>
                                <tr>
                                    <td>HP</td>
                                    <td>{{c.hp}}</td>
                                </tr>
                                <tr>
                                    <td>Saving Throws</td>
                                    <td>
                                        <span v-for="s in c.saving_throws" :key="s"> {{s}} </span>
                                    </td>
                                </tr>
                                <tr v-if="c.spellcast_mod">
                                    <td>Spellcast Modifier</td>
                                    <td>{{c.spellcast_mod}}</td>
                                </tr>
                                <tr>
                                    <td>Features</td>
                                    <td>
                                        <div v-for="f in c.classFeatures" :key="f.id"  >
                                            {{f.name}}
                                            <p class="minitext" v-html="f.small_desc"></p>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name:'class',
    data(){
        return {
            class_data  : 0,
            showClass   : 0,
            visable     : 0,
        }
    },
    computed:{
        classes(){
            if (!this.class_data){
                this.$parent.getData('class',this.checkResponse);
            }
            return this.class_data;
        }
    },
    methods:{
        checkResponse($data){
            this.class_data = $data;
        },
        updateParent(){
            this.$parent.clas.id = this.showClass;
            this.$parent.scroll.showRight= 1;
            this.$parent.update('clas');
        },
    }

}
</script>
