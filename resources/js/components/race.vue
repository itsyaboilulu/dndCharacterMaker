<template>
    <section id="race" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Pick A Race</h2>
            </header>
            <div class="options-data-box">
                <div class="options">
                    <ul class="select-list">
                        <li v-for="race in races" :key="race.id" v-on:click="showRace=race.id; updateParent();" :class="{select:showRace==race.name}" > {{ race.name }}  </li>
                    </ul>
                </div>
                <div class="data">
                    <div v-for="race in races" :key="race.id"  >
                        <div class="info-box" v-if="showRace === race.id" >
                            <table>
                                <tr>
                                    <td>Size</td>
                                    <td>
                                        <i class="fas fa-male fasmall"  :class="{ unselect:race.size != 'Small' }" ></i>
                                        <i class="fas fa-male famedium" :class="{ unselect:race.size != 'Medium' }"></i>
                                        <i class="fas fa-male fatall"   :class="{ unselect:race.size != 'Tall' }"></i>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Moves</td>
                                    <td>{{ race.speed/5 }} <i class="fas fa-arrows-alt"></i></td>
                                </tr>
                                <tr>
                                    <td>Ability Modifier</td>
                                    <td>
                                        <div v-for="(value,key) in race.ability.bonus" :key='key'>
                                            {{key}}:+{{value}}
                                        </div>
                                        <div v-if="race.ability.options.choose">
                                            + {{race.ability.options.choose}} in a chosen ability, in later section
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="race.prof.options.choose || race.prof.prof.length > 0" >
                                    <td>Proficiencies</td>
                                    <td>
                                        <div v-if="race.prof.prof.length > 0" >
                                            {{arrToStr(race.prof.prof)}}
                                        </div>
                                        <div v-if="race.prof.options.choose">
                                           Choose {{race.prof.options.choose}} skills of your choice, in later section
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Languages</td>
                                    <td>
                                        <div v-if="race.lang.lang.length > 0" >
                                            {{arrToStr(race.lang.lang)}}
                                        </div>
                                        <div v-if="race.lang.options.choose" >
                                            {{race.lang.options.choose}} languages of your choice, in later section
                                        </div>
                                    </td>
                                </tr>
                                <tr v-if="race.traits.traits.length > 0">
                                    <td>Traits</td>
                                    <td>
                                        <div v-for="item in race.traits.traits" :key="item" >
                                            <div v-for="t in traits" :key='t.id' >
                                                <div v-if="t.name == item && t.small_desc" >{{item}} <p class="minitext"> {{t.small_desc}}</p>
                                                    <select :bind="extra" v-on:change="updateParent()" id='dragon_breath' v-if="item == 'Breath Weapon'" >
                                                        <option v-for="from in race.traits.options.from" :key="from" :value="from">{{from}}</option>
                                                    </select>
                                                </div>
                                            </div>
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
    name:'race',
    props:['races','traits'],
    data(){
        return{
            showRace:0,
            extra   :0,
        }
    },
    methods:{
        arrToStr($arr){
            var str;
            for(var i=0;i<$arr.length;i++){
                str = (str) ? str +', '+ $arr[i] : $arr[i] ;
            }
            return str;
        },
        updateParent(){
            this.$parent.race.id = this.showRace;
            this.$parent.scroll.showRight= 1;
            if (this.showRace == 5){
                this.$parent.race.extra = this.extra;
            }
            this.$parent.update('race');
        },
    }

}
</script>
