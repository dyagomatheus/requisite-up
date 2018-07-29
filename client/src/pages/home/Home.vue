<template>
  <site>
    <span slot="menu">
    <div class="row valign-wrapper card-content">
        <grid tamanho="12">
        <img src="https://i.pinimg.com/originals/6e/a2/4c/6ea24c9ef4199d542c9321b14517fa67.png" alt="" class="responsive-img img-border">
        <span class="black-text">
          <h5 class="center">{{user.user.name}}</h5>
        <span class="font">
          <p>{{user.user.bio}}</p>
          <p class="center-align">#ID: {{user.user.id}}</p>
          <ul class="collection">
             <li class="collection-item backgroud center">
                 <h6>PROJETOS</h6> 
              </li>
              <li class="collection-item">
                  TOTAL
                  <span class="badge">{{user.count}}</span>
              </li>
               <li class="collection-item">
                  NÃO FINALIZADOS
                  <span class="badge">{{user.count2}}</span>
              </li>
              <li class="collection-item">
                  FINALIZADOS
                  <span class="badge">{{count3}}</span>
              </li>
          </ul>
        </span>
          </span>
        </grid>
      </div>
    </span>
    <span slot="arealogin">
      <create></create>
        <h4>{{msg}}</h4>
            <div class="row" v-for="item in listProjects" :key="item.id">
                <div class="col s12">
                  <div class="card">
                    <div class="card-content">
                      <span class="card-title">{{item.title}}</span>
                      <p>{{item.description}}</p>
                      <p class="right-align">Data para finalização: {{item.due_date}}</p>

                    </div>
                    <div class="card-action">
                      <router-link :to="'/project/'+item.id"  class="waves-effect waves-light btn light-blue darken-4"><i class="material-icons right">settings</i>Gerenciar</router-link>
                      <span>
                      <a class="waves-effect waves-light btn red darken-4 right"><i class="material-icons right">delete</i>Deletar</a>
                      </span>
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
import Create from '@/components/projects/Create';
import Grid from '@/components/layouts/Grid';

export default {
  name: 'Home',
  data () {
    return {
      msg: 'Meus projetos',
      user:'',
      count:'',
      count2:'',
      count3:'',
      project: {id:'', done:''}
    }
  },
  created() {
    
    this.count = this.$store.getters.getCount
    this.count2 = this.$store.getters.getCount2
    this.count3 = this.$store.getters.getCount3
    let userAux = this.$store.getters.getUser
    if(userAux){
      this.$Progress.start()
      this.user = this.$store.getters.getUser
      this.$http.get(this.$api+'project/user/' + this.user.user.id,     
      {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {
    console.log(response.data);
    if(response.data){
      this.$Progress.finish()
      this.$store.commit('setprojectList', response.data.data)
    }
    })
    .catch(e => {
      this.$Progress.fail()
      console.log(e)
    })
    }
  },
  components:{
    CardProject,
    Create,
    Site,
    Grid
  },
  computed:{
    listProjects(){
      return this.$store.getters.getProjectsList
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

.img-border{
  border-radius: 8px;
}

.icon_style{
position: absolute;
right: 10px;
top: 10px;
font-size: 20px;
color: white;
cursor:pointer; 
}
.backgroud{
   background: #e5e5e5
  }
</style>
