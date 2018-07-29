<template>
<span>
  <header>
    <navbar url="#/">
    <li v-if="user"><router-link to="/"><i class="material-icons">home</i></router-link></li>
     <li v-if="user"><router-link to="/perfil">{{ user.user.name }}</router-link></li>
     <li v-if="user"><a v-on:click="logout()">Sair</a></li>
    </navbar>
  </header>
  <main>
    <div class="container">
        <div class="row">
          <grid tamanho="4">
                    <card-menu>
                    <slot name="menu" />
                    </card-menu>
          </grid>
          <grid tamanho="8">
              <slot name="arealogin"/>
          </grid>
        </div>
    </div>
  </main>
        <footer-vue>
        </footer-vue>  
</span>  
</template>

<script>
import Navbar from '@/components/layouts/Navbar';
import FooterVue from '@/components/layouts/FooterVue';
import Grid from '@/components/layouts/Grid';
import CardMenu from '@/components/layouts/CardMenu';

export default {
  data () {
    return {
      user: false
    }
  },
  name: 'Site',
  components:{
    Navbar,
    FooterVue,
    Grid,
    CardMenu
  },
  created() {
    console.log('created()');
    let userAux = this.$store.getters.getUser;
    if(userAux){
      this.user = this.$store.getters.getUser;
    }else{
      this.$router.push('/login');
    }
  },
  methods:{
    logout(){
      this.$store.commit('setUser', null);
      sessionStorage.clear();
      this.user = false;
      this.$router.push('/login');
    }
  }
}
</script>

<style>
.font{
  font-size: 14px;
  color: #37474f;
}
</style>
