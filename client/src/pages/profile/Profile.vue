<template>
<site>
    <span slot="arealogin">
        <h4>Perfil</h4>
          <input type="text" placeholder="Nome" v-model="name"/>
          <input type="text" placeholder="E-mail" v-model="email" />
          <input type="text" placeholder="Bio" v-model="bio" />
          <input type="password" placeholder="Senha" v-model="password" />
          <button class="btn" v-on:click="profile()">Atualizar dados</button>
    </span>
    <span slot="menu">
        <img src="https://i.pinimg.com/originals/6e/a2/4c/6ea24c9ef4199d542c9321b14517fa67.png" class="responsive-img"/>
        <div class="file-field input-field">
          <div class="btn">
            <span>Alterar Foto</span>
            <input type="file" >
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
    </span>
</site>
</template>

<script>
import Site from '@/templates/Site';

export default {
  name: 'Profile',
  data () {
    return {
      user: false,
      msg: 'Meus projetos',
      name:'',
      email: '',
      password: '',
      bio:'',
      image:''
    }
  },
  components:{
    Site
  },
  created() {
    let userAux = this.$store.getters.getUser;
    if(userAux){
      this.user = this.$store.getters.getUser;
      this.name = this.user.user.name;
      this.email = this.user.user.email;
      this.bio = this.user.user.bio;

    }else{
      this.$router.push('/login');
    }
  },
  methods:{
 /*** uploadImage(e){
    let file = e.target.files || e.dataTransfer.files;
    if(!file.length){
      return;
    }
    let reader = new FileReader();
    reader.onloadend = (e) => {
      this.image = e.target.result;
    };

    reader.readAsDataURL(file[0]);
    console.log(this.image);
  },***/
  profile(){
      //console.log("ok");
      this.$http.put(this.$api+`update`, {
      name: this.name,
      email: this.email,
      password: this.password,
      bio: this.bio
    }, {"headers":{"authorization": "Bearer "+this.$store.getters.getToken }})
    .then(response => {
    console.log(response.data);
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