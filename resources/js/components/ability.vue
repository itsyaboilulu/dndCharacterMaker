<template>
    <section id="abilities" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Select Ability Scores</h2>
            </header>
            <div class="options-data-box">
                <div class="options">
                    <ul class="select-list">
                        <li v-on:click="rollAll()" >Roll</li>
                        <li v-on:click="standered()" >Standered List</li>
                    </ul>
                </div>
                <div class="data">
                    <table>
                        <tr>
                            <th></th>
                            <th>Bonus</th>
                            <th>Roll</th>
                            <th>Points</th>
                            <th>Modifier</th>
                        </tr>
                        <tr v-for="a in abilitys" :key='a.id' >
                            <td>
                                {{a.name}}
                                <div class="minitext">- {{ ability_desc[a.shortname] }}</div>
                            </td>
                            <td class="center">
                                {{(a.bonus > 0)?a.bonus:null}}
                            </td>
                            <td class="center">
                                <input type="number" min="1" :max="30-a.bonus" v-model="input_scores[a.shortname]" v-on:change="calcScore(a.shortname)" >
                            </td>
                            <td class="center"> {{ ability_scores[a.shortname] }} </td>
                            <td class="center"> {{ ability_mod[a.shortname] }} </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name:'ability',
    data(){
        return {
            ability_data    : 0,
            showability     : 0,
            ability_mod     : {
                STR : 1,
                DEX : 1,
                CON : 1,
                INT : 1,
                WIS : 1,
                CHA : 1
            },
            ability_scores  : {
                STR : 1,
                DEX : 1,
                CON : 1,
                INT : 1,
                WIS : 1,
                CHA : 1
            },
            input_scores    : {
                STR : 1,
                DEX : 1,
                CON : 1,
                INT : 1,
                WIS : 1,
                CHA : 1
            },
            ability_desc    : {
                STR : 'Morbidly weak',
                DEX : 'Barely mobile',
                CON : 'Minimal immune system',
                INT : 'Smooth brain',
                WIS : 'Seemingly incapable of thought',
                CHA : 'Barely conscious'
            },
            standerd        : [ 15,14,13,12,10,8 ],
            visable         : 0,
        }
    },
    computed:{
        abilitys(){
            if (!this.ability_data){
                this.$parent.getData('abilities',this.checkResponse);
            }
            return this.ability_data;
        }
    },
    methods:{
        checkResponse($data){
            this.ability_data = $data;
        },
        calcScore($shortname){
            let ability = this.getAbility($shortname);
            //sets vars to NAN if consol.log() is not here
            console.log();
            this.ability_scores[$shortname] = (+this.input_scores[$shortname] + +((ability.bonus)?ability.bonus:0));
            this.ability_mod[$shortname] = Math.floor( ( this.ability_scores[$shortname] - 10 ) / 2 );
            this.updateAPD($shortname);
            this.updateParent();
        },
        updateAPD($shortname){
            var p = 1;
            if (this.ability_scores[$shortname] > 1){
                p = (this.ability_scores[$shortname]%2 == 0) ? this.ability_scores[$shortname] : (this.ability_scores[$shortname] - 1);
            }
            let ability = this.getAbility($shortname);
            for (let j = 0; j < ability.apd.length; j++) {
                const apd = ability.apd[j];
                if (apd['points'] == p){
                    this.ability_desc[$shortname] = apd.desc;
                    break;
                }
            }

        },
        getAbility($shortname){
            for (let i = 0; i < this.abilitys.length; i++) {
                const element = this.abilitys[i];
                if (element.shortname == $shortname){
                    return element;
                }
            }
        },
        updateParent(){
            this.$parent.ability = this.ability_scores;
            this.$parent.update('ability');
        },
        standered(){
            this.setRecomended([ 15,14,13,12,10,8 ]);
        },
        roll(){
            var rolls=[];
            for(let i=0;i<4;i++){ rolls.push(Math.ceil(Math.random()*6)); }
            rolls = rolls.sort((a, b) => b - a);
            return +rolls[0] + +rolls[1] + +rolls[2];
        },
        rollAll(){
            var rolls=[];
            for(let j=0; j < 6; j++) { rolls.push(this.roll()); }
            this.setRecomended(rolls);
        },
        setRecomended($arr){
            let rolls = $arr.sort((a, b) => b - a);
            var ret = [];
            for (let i = 0; i < this.abilitys.length; i++) {
                const ab = this.abilitys[i];
                this.input_scores[ab.shortname] = rolls[ (ab.rank - 1) ];
                this.calcScore(ab.shortname);
            }
        },
    }
}
</script>
