<template>
    <span>
      <div class="row">
        <grid class="input-field" tamanho="12">
         <input type="text" placeholder="Insira aqui o EMAIL do usuário"  v-model="create.email"/>
        <input type="text" placeholder="Insira a função do usuário"  v-model="create.type_user"/>
        </grid>
          <p>
            <a class="waves-effect waves-light btn blue-grey lighten-4 black-text col s2 offset-s10" v-on:click="addMember()"><i class="material-icons right">send</i>Adicionar</a>
          </p>
      </div>
    </span>
</template>

<script>
import Grid from '@/components/layouts/Grid';

export default {
  name: 'AddMember',
  data () {
    return {
      msg: 'Meus projetos',
      create: {email:'', type_user:''}
    }
  },
  components:{
    Grid
  },
  methods:{
    addMember(){
      console.log("ok");
      this.$http.post(this.$api+'addmember/'+ this.$route.params.id +'/project',
      {
        email: this.create.email,
        type_user: this.create.type_user
      },      
      {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {
    console.log(response.data.data);
    swal ( "Usuário adicionado com sucesso" ,  "" ,  "success" )
    this.create = {email:'', type_user:''}
    this.$store.commit('setTasksList', response.data.data)
    this.$router.push('/project/'+this.$route.params.id);
   // location.reload()
    })
    .catch(e => {
      console.log(e)
          swal ( "Oops!" ,  "Insira um emal válido." ,  "warning" )

    })
    }
  },
  computed:{
    listTasks(){
      return this.$store.getters.getTasksList
      }
  }
}
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  }); 
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.input-field textarea[class=materialize-textarea]:focus {
border-bottom: 1px solid #01579b;
box-shadow: 0 1px 0 0 #01579b;
}
</style>
