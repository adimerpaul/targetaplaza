<template>
<q-page class="q-pa-md">
  <div class="row">
    <div class="col-12">
    <q-form @submit.prevent="consulta">
      <div class="row">
        <div class="col-10"><q-input v-model="ci" label="Carnet de identidad" outlined required/></div>
        <div class="col-2"><q-btn icon="send" label="Consultar" color="primary" type="submit"/></div>
      </div>
    </q-form>
    </div>
<!--    {{ci}}-->
    <div class="col-12">
      <q-table title="Historiales de targetas" :columns="columns" :rows="datos"/>
    </div>
  </div>
</q-page>
</template>

<script>
export default {
  data(){
    return{
      ci:'',
      columns:[
        {label:'apellido',name:'apellido',field:'apellido'},
        {label:'nombre',name:'nombre',field:'nombre'},
        {label:'celular',name:'celular',field:'celular'},
        {label:'saldo',name:'saldo',field:'saldo'},
      ],
      datos:[]
    }
  },
  methods:{
    consulta(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/historial/'+this.ci).then(res=>{
        // console.log(res.data)
        this.datos=res.data
        this.$q.loading.hide()
      })
    }
  }
}
</script>

<style scoped>

</style>
