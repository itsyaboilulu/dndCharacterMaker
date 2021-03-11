<template>

    <div id='createcharacter'>
        <!--
        <section id="intro" class="main style1 dark fullscreen">
            <div class="content">
                <header>
                    <h2>Hey.</h2>
                </header>
                <p>Welcome to <strong>Big Picture</strong> a responsive site template designed by <a href="https://html5up.net">HTML5 UP</a><br />
                and released for free under the <a href="https://html5up.net/license">Creative Commons Attribution license</a>.</p>
                <footer>
                    <a href="#race" class="button style2 down">More</a>
                </footer>
            </div>
        </section>
        -->
        <race
            v-bind:races    ="races"
            v-bind:traits   ="traits"
        ></race>
        <class      v-if="race.id"          ></class>
        <background v-if="clas.id"          ></background>
        <ability    v-if="background.id"    ></ability>
        <skills     v-if="ability"          ></skills>
        <equitment  v-if="skills"           ></equitment>
        <spells     v-if="equitment"        ></spells>
        <a v-if="left.label != ''" v-on:click="jump(left.link);scroll.pos--;" class="button style2 left anchored" >{{left.label}}</a>
        <a v-if="scroll.showRight" v-on:click="jump(right.link);scroll.pos++;" class="button style2 right anchored" >{{right.label}}</a>
    </div>
</template>
<script>
import { ajax }         from "../ajax.min.js";
export default {
    name:'createcharacter',
    props:['races','traits'],
    data(){
        return {
            race:{
                id          : 0,
                extra       : 0
            },
            clas:{
                id          : 0,
            },
            background:{
                id          : 0,
                extra       : [0,0],
            },
            ability         : 0,
            skills          : 0,
            equitment       : 0,
            spells          : 0,
            scroll: {
                showLeft    : 0,
                showRight   : 0,
                pos         : 1,
                labels      : ['','Race','Class','Background','Ability Score','Skills','Equitment','Spells'],
                links       : ['','#race','#class','#background','#abilities','#skills','#equitment','#spells'],
                check       : ['race','race','clas','background','ability','skills','equitment','spells']
            },

        }
    },
    computed:{
        left(){
            return this.scrollButton(-1);
        },
        right(){
            return this.scrollButton(1);
        }
    },
    watch:{
        ability(){
            this.right;
        },
        skills(){
            this.right;
        },
        equitment(){
            this.right;
        }
    },
    methods:{
        update($page){
            var data =  this[$page];
            ajax(this.checkResponse, 'character/update',{
                'item'  : $page,
                'data'  : JSON.stringify(data),
            },0)
        },
        getData($page,$response){
            return ajax( $response, 'internal/'+$page, null, 1 );
        },
        checkResponse($data){
            console.log($data);
        },
        scrollButton($mod){
            this.scroll.showRight = (typeof this[this.scroll.check[ this.scroll.pos ]].id !== 'undefined') ?
                ((this[this.scroll.check[ this.scroll.pos ]].id)    ? 1 : 0) :
                ((this[this.scroll.check[ this.scroll.pos ]])       ? 1 : 0);
            let pos = this.scroll.pos + $mod;
            if (!pos){
                this.scroll.showLeft = 0;
            }
            return {
                label   : this.scroll.labels[pos],
                link    : this.scroll.links[pos],
            }
        },
        jump($anchor){
            window.location.href = $anchor;
        },
    }
}
</script>
