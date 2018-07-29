<template>
<span>
  <header>
    <navbar url="#/">
     <li><a href="#/login">Entrar</a></li>
     <li><a href="#/cadastro">Cadastre-se</a></li>
    </navbar>
  </header>
  <main>
    <div class="container">
        <div class="row">
          <grid tamanho="8">
            <card-menu>
              <slot name="menu"/>
            </card-menu>
          </grid>
          <grid tamanho="4">
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
  name: 'LoginTemplate',
  components:{
    Navbar,
    FooterVue,
    Grid,
    CardMenu
  },
    created() {
    let userAux = this.$store.getters.getUser;
    if(userAux){
      this.user = this.$store.getters.getUser;
      this.$router.push('/');
    }
  },
  methods:{
    logout(){
      this.$store.commit('setUser', null);
      sessionStorage.clear();
      this.user = false;
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
