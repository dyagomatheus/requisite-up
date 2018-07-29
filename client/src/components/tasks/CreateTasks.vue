<template>
    <span>
      <div class="row">
        <grid class="input-field" tamanho="12">
          <input placeholder="Titulo" type="text" v-model="create.title"/>
          <textarea v-if="create.title" placeholder="Descrição" v-model="create.description" class="materialize-textarea"></textarea>
          <span v-if="create.title && create.description">Data final</span>
          <input v-if="create.title && create.description" type="date" v-model="create.due_date"/>
           <input v-if="create.title && create.description" placeholder="Tempo para desenvolvimento"  v-model="create.runtime"/>
            <input v-if="create.title && create.description" placeholder="Risco"  v-model="create.risk"/>
          <input v-if="create.title && create.description"  placeholder="Usuário encarregado"  v-model="create.user_id"/>
          <input v-if="create.title && create.description" placeholder="Valor para o Cliente"  v-model="create.value_client"/>

          <label>Crie uma nova tarefa</label>
        </grid>
          <p>
            <a v-if="create.title && create.description" class="waves-effect waves-light btn blue-grey lighten-4 black-text col s2 offset-s10" v-on:click="createTask()"><i class="material-icons right">send</i>Criar</a>
          </p>
      </div>
    </span>
</template>

<script>
import Grid from '@/components/layouts/Grid';

export default {
  name: 'CreateTasks',
  data () {
    return {
      msg: 'Meus projetos',
      create: {title:'', description:'', due_date:'', user_id:'', runtime:'', risk:'', value_client:''}
    }
  },
  components:{
    Grid
  },
  methods:{
    createTask(){
      console.log("ok");
      this.$http.post(this.$api+'project/'+ this.$route.params.id +'/tasks/create',
      {
        title: this.create.title,
        description: this.create.description,
        due_date: this.create.due_date,
        user_id: this.create.user_id,
        risk: this.create.risk,
        runtime: this.create.runtime,
        value_client: this.create.value_client
      },      
      {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {
    //console.log(response.data.data);
    swal ( "Tarefa cadastrada com sucesso" ,  "" ,  "success" )
    this.create = {title:'', description:'', due_date:'', user_id:''}
    this.$store.commit('setTasksList', response.data.data)
    this.$router.push('/project/'+this.$route.params.id);
   // location.reload()
    })
    .catch(e => {
      console.log(e)
    })
    }
  },
  computed:{
    listTasks(){
      return this.$store.getters.getTasksList
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
