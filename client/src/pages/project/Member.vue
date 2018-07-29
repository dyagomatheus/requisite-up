<template>
  <site>
    <span slot="menu">
    <div class="row valign-wrapper card-content">
        <grid tamanho="12">
        <span class="black-text">
        <ul class="collection with-header">
          <li class="collection-header center-align">Nome do Projeto<br /> <h5>{{project.title}}</h5></li>
          <li class="collection-item">{{project.description}}</li>
          <li class="collection-item">Termino: {{project.due_date}}</li>
        </ul>        
        <ul class="collapsible">
          <li>
            <div class="collapsible-header">
              <i class="material-icons">note</i>
              Lembretes
              <span class="new badge blue">4</span></div>
          </li>
        </ul>
        <ul class="center-align collection with-header backgroud">
        <h5>
          Equipe
        </h5>
         <li class="collection-item avatar" v-for="item in member" :key="item.id">
            <img src="https://i.pinimg.com/originals/6e/a2/4c/6ea24c9ef4199d542c9321b14517fa67.png" alt="" class="circle">
            <span class="title">{{item.name}}</span>
            <p class="font">{{item.pivot.type_user}}</p>
          </li>
        </ul> 
          <a :href="'#/addmember/'+project.id+'/project'" class="waves-effect waves-light btn light-blue darken-4 col s12"><i class="material-icons right">group_add</i>Adicionar Membro</a>
          <br />          <br />
          <a class="waves-effect waves-light btn green darken-4 col s12" v-on:click="ProjectDone()"><i class="material-icons right">done</i>Finalizar</a>
          </span>
          <div class="card-action">
          </div>
        </grid>
      </div>
    </span>
    <span slot="arealogin">
      <add-member></add-member>
        <h4>{{msg}}</h4>
            <div class="row" v-for="item in listTasks" :key="item.id" v-if="user.user.id == item.user_id">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">{{item.title}}</span>
                      <p>{{item.description}}</p>
                      <p></p>
                      <p class="right-align">Data para finalização: {{item.due_date}}</p>
                      <p class="right-align" v-show="item.id">Usuário responsável: {{user.user.name}}</p>
                    </div>
                    <div class="card-action">
                      <a class="waves-effect waves-light btn light-blue darken-4"><i class="material-icons right">settings</i>Gerenciar</a>
                    </div>
                  </div>
                </div>
            </div>
    </span>
  </site>
</template>

<script>
import Site from '@/templates/Site';
import CardProject from '@/components/projects/CardProject';
import AddMember from '@/components/projects/AddMember';
import Grid from '@/components/layouts/Grid';

export default {
  name: 'Member',
  data () {
    return {
      msg: "Adicione um novo membro ao projeto",
      user:'',
      project:'',
      member:'',
      pivot:'',
      done:''
    }
  },
  created() {
    let userAux = this.$store.getters.getUser;
    if(userAux){
      this.user = this.$store.getters.getUser;
      this.$http.get(this.$api+'projects/'+ this.$route.params.id +'/tasks',     
      {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {
    this.project = response.data.project
    this.member = response.data.users
    if(this.project.pivot.type_user != 'Gerente'){
    swal ( "Oops" ,  "Você não é Gerente deste projeto. Por favor, entre em contato com o Gerente." ,  "error" )
    this.$router.push('/project/'+this.$route.params.id);
    }
    //console.log(response.data.users);
    if(this.user.id == response.data.tasks.user_id ){
      console.log(this.member);
      this.$store.commit('setTasksList', response.data.tasks)
    }
    })
    .catch(e => {
      console.log(e)
      swal ( "Oops" ,  "Você não faz parte da equipe deste projeto. Por favor, entre em contato com o Gerente." ,  "error" )
      this.$router.push('/');
    })
    }
  },
  methods:{
    ProjectDone(){
        //console.log("ok");
        this.$http.put(this.$api+`project/done/update/`+ this.$route.params.id, {
      }, {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
      .then(response => {
      swal ( "Parabéns" ,  "Projeto finalizado com sucesso" ,  "success" )
      this.$router.push('/');
      console.log(response.data);
      })
      .catch(e => {
        console.log(e)
      })
      }
    },
  components:{
    CardProject,
    Site,
    Grid,
    AddMember
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
  .backgroud{
   background: #e5e5e5
  }
  .font{
    font-size: 12px;
  }
</style>
