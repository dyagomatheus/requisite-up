<template>
    <span>
      <div class="row">
        <grid class="input-field" tamanho="12">
          <input placeholder="Titulo" type="text" v-model="create.title"/>
          <textarea v-if="create.title" placeholder="Descrição" v-model="create.description" class="materialize-textarea"></textarea>
          <span v-if="create.title && create.description">Data final</span>
          <input v-if="create.title && create.description" type="date" v-model="create.due_date"/>


          <label>Crie um novo projeto</label>
        </grid>
          <p>
            <a v-if="create.title && create.description" class="waves-effect waves-light btn blue-grey lighten-4 black-text col s2 offset-s10" v-on:click="createProject()"><i class="material-icons right">send</i>Criar</a>
          </p>
      </div>
    </span>
</template>

<script>
import Grid from '@/components/layouts/Grid';

export default {
  name: 'Create',
  data () {
    return {
      msg: 'Meus projetos',
      create: {title:'', description:'', due_date:'', done: 0}
    }
  },
  components:{
    Grid
  },
  methods:{
    listProjects(){
      return this.$store.getters.getProjectsList
    },
    createProject(){
      console.log("ok");
      this.$http.post(this.$api+'project/create',
      {
        title: this.create.title,
        description: this.create.description,
        due_date: this.create.due_date,
        done: this.create.done
      },      
      {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {  
    console.log(response.data);
    swal ( "Projeto criado com sucesso" ,  "" ,  "success" )
    this.create = {title:'', description:'', due_date:'', done: 0}
    this.$store.getters.getCount2 + 1
    this.$store.commit('setprojectList', response.data.data)
    //location.reload()
      
    })
    .catch(e => {
      console.log(e)
      if(e == 500)
      swal ( "Oops" ,  "Por favor, preencha todos os campos." ,  "warning" )
    })
    }
  },
  computed:{
    listProjects(){
      return this.$store.state.response.data.data
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
