<template>
    <section id="background" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Pick A Background</h2>
            </header>
            <div class="options-data-box">
                <div class="options">
                    <ul class="select-list">
                        <li v-for="b in background" :key="b.id"
                            v-on:click="showbackground=b.id; updateParent();"
                            :class="{select:showbackground == b.id}" > {{ b.name }}  </li>
                    </ul>
                </div>
                <div class="data">
                    <div v-for="b in background" :key="b.id"  >
                        <div class="info-box" v-if="showbackground === b.id" >
                            <table>
                                <tr v-if="b.tools">
                                    <td>Tools</td>
                                    <td>{{b.tools}}</td>
                                </tr>
                                <tr v-if="b.languages">
                                    <td>Languages</td>
                                    <td>
                                        <select v-for="index in b.languages" :key="index" v-on:change="updateExtra($event, index)">
                                            <option v-for="l in languages" :key="l.id" :value="l.id" >{{l.name}}</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td>skills</td>
                                    <td>{{ b.skill1 }}, {{ b.skill2 }}</td>
                                </tr>
                                <tr>
                                    <td>Feature</td>
                                    <td>{{ b.feature.name }}<br><i class="minitext"> - {{ b.feature.short_desc }}</i></td>
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
    name:'background',
    data(){
        return {
            background_data  : 0,
            languages_data   : 0,
            showbackground   : 0,
            visable          : 0,
        }
    },
    computed:{
        background(){
            if (!this.background_data){
                this.$parent.update('clas');
                this.$parent.update('race');
                this.$parent.getData('background',this.checkResponse);
            }
            return this.background_data;
        },
        languages(){
            if (!this.languages_data){
                this.$parent.getData('language',this.checkLanguage);
            }
            return this.languages_data;
        }
    },
    methods:{
        checkResponse($data){
            this.background_data = $data;
        },
        checkLanguage($data){
            this.languages_data = $data;
        },
        updateParent(){
            this.$parent.background.id = this.showbackground;
            this.$parent.scroll.showRight= 1;
            this.$parent.update('background');
        },
        updateExtra( $this, $index){
            this.$parent.background.extra[$index] = $this.value;
        },
    }
}
</script>
