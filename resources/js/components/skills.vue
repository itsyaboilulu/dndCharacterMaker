<template>
    <section id="skills" class="main style2 dark fullscreen" >
        <div class="content box style2">
            <header>
                <h2>Pick {{ skills.pick - added }} Skills</h2>
            </header>
            <div class="options-data-box">
                <div v-for="(items, index) in skills.skills" :key='index' class="options">
                    <h4>{{index}}</h4>
                    <ul class="select-list skills">
                        <li v-for='(item, iindex) in items' :key="iindex" :class="{select:item.set}" v-on:click="select($event,index,iindex)">{{item.name}}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
export default {
    name:'skills',
    data(){
        return {
            skills_data  : 0,
            showskills   : 0,
            added        : 0,
            selected     : [],
        }
    },
    computed:{
        skills(){
            if (!this.skills_data){
                this.$parent.getData('skills',this.checkResponse);
            }
            return this.skills_data;
        }
    },
    methods:{
        checkResponse($data){
            this.skills_data = $data;
        },
        updateParent(){
            if (this.added == this.skills.pick){
                this.$parent.skills = this.selected;
                this.$parent.update('skills');
            } else {
                this.$parent.skills = 0;
            }
        },
        select($element,$ab,$skill) {
            let element = $element.target;
            if (!this.skills.skills[$ab][$skill].set){
                if (element.classList.contains('select')){
                    //remove
                    this.selected = this.removeFromArr(this.selected,this.skills.skills[$ab][$skill].id);
                    element.classList.toggle('select');
                    this.added--
                    this.updateParent();
                } else {
                    //add
                    if (this.added < this.skills.pick) {
                        this.selected.push(this.skills.skills[$ab][$skill].id);
                        element.classList.toggle('select');
                        this.added++
                        this.updateParent();
                    }
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

}
</script>
