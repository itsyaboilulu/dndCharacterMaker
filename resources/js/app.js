window.Vue = require('vue').default;

Vue.component('createcharacter',    require('./components/createcharacter.vue').default);

Vue.component('race',           require('./components/race.vue').default);
Vue.component('class',          require('./components/class.vue').default);
Vue.component('background',     require('./components/background.vue').default);
Vue.component('ability',        require('./components/ability.vue').default);
Vue.component('skills',         require('./components/skills.vue').default);
Vue.component('equitment',      require('./components/equitment.vue').default);
Vue.component('spells',         require('./components/spells.vue').default);


const app = new Vue({ el: '#app', });

