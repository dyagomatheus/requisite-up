<template>
<login-template>
    <span slot="arealogin">
        <h4>Cadastro</h4>
          <input type="text" placeholder="Nome" v-model="name"/>
          <input type="text" placeholder="E-mail" v-model="email" />
          <input type="password" placeholder="Senha" v-model="password" />
          <button class="btn" v-on:click="register()">Enviar</button>
          <router-link class="btn red darken-4" to="/login">cancelar</router-link>
    </span>
    <span slot="menu">
        <img src="http://www.liquidplanner.com/wp-content/uploads/HiRes-17.jpg" class="responsive-img"/>
    </span>
</login-template>
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate';

export default {
  name: 'Register',
  data () {
    return {
      msg: 'Meus projetos',
      name:'',
      email: '',
      password: ''
    }
  },
  components:{
    LoginTemplate
  },
  methods:{
  register(){
      //console.log("ok");
      this.$http.post(this.$api+`register`, {
      name: this.name,
      email: this.email,
      password: this.password
    })
    .then(response => {
      //console.log(response)
      if(response.data.token){
        this.$store.commit('setUser', response.data);
        sessionStorage.setItem('user', JSON.stringify(response.data));
        this.$router.push('/');
      }
    })
    .catch(e => {
      console.log(e)
    })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.input-field textarea[class=materialize-textarea]:focus {
border-bottom: 1px solid #01579b;
box-shadow: 0 1px 0 0 #01579b;
}
</style>