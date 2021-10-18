<template>
  <q-page class="q-pa-xs">
    <div class="row">
      <div class="col-12">
        <q-form @submit.prevent="crear()">
          <div class="row">
            <div class="col-2"><q-input autofocus label="ci" v-model="dato.ci" dense outlined required/></div>
            <div class="col-2"><q-input label="nombre" v-model="dato.nombre" dense outlined required/></div>
            <div class="col-2"><q-input label="apellido" v-model="dato.apellido" dense outlined required/></div>
            <div class="col-2"><q-input type="date" label="fechanac" v-model="dato.fechanac" dense outlined required/></div>
            <div class="col-1"><q-input label="celular" v-model="dato.celular" dense outlined required/></div>
            <div class="col-2"><q-input label="codigo" v-model="dato.codigo" dense outlined required/></div>
            <div class="col-1 flex flex-center">
              <q-btn size="xs" label="crear" color="primary" type="submit" icon="send"/>
            </div>
          </div>
        </q-form>
      </div>
      <div class="col-12">
        <q-table title="Clientes" dense :columns="columns" :rows="clientes" :filter="filter">
          <template v-slot:top-right>
            <q-input borderless dense debounce="300" v-model="filter" placeholder="Buscar">
              <template v-slot:append>
                <q-icon name="search" />
              </template>
            </q-input>
          </template>
          <template v-slot:body="props">
            <q-tr :props="props">
              <q-td key="ci" :props="props">
                {{ props.row.ci }}
              </q-td>
              <q-td key="nombre" :props="props">
<!--                <q-badge color="green">-->
                  {{ props.row.nombre }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="apellido" :props="props">
<!--                <q-badge color="purple">-->
                  {{ props.row.apellido }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="fechanac" :props="props">
<!--                <q-badge color="orange">-->
                  {{ props.row.fechanac }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="direccion" :props="props">
<!--                <q-badge color="primary">-->
                  {{ props.row.direccion }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="celular" :props="props">
<!--                <q-badge color="teal">-->
                  {{ props.row.celular }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="saldo" :props="props">
<!--                <q-badge color="accent">-->
                  {{ props.row.saldo }}
<!--                </q-badge>-->
              </q-td>
              <q-td key="codigo" :props="props">
<!--                <q-badge color="amber">-->
                  {{ props.row.codigo }}
<!--                </q-badge>-->
              </q-td>
              <q-td>
                <q-btn size="xs" @click="showrecarga(props.row)" label="Recargar" icon="payment" color="primary"/>
              </q-td>
            </q-tr>
          </template>
        </q-table>
        <q-dialog v-model="boolrecarga" >
          <q-card style="width: 500px; max-width: 80vw;">
            <q-card-section>
              <div class="text-h6">Recargar: {{cliente.nombre}} {{cliente.apellido}} <q-icon name="payment"/></div>
            </q-card-section>

            <q-card-section class="q-pt-none">
              <q-form @submit.prevent="guardarrecarga">
                <div class="row">
                  <div class="col-10"><q-input label="Monto de recarga" type="Number" v-model="recarga" outlined required /></div>
                  <div class="col-2 flex flex-center"><q-btn dense color="primary" type="submit" label="recargar" icon="payment"/></div>
                </div>
              </q-form>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn flat label="Cerrar" icon="delete" color="primary" v-close-popup />
            </q-card-actions>
          </q-card>
        </q-dialog>
      </div>
    </div>
  </q-page>
</template>

<script>
import {date} from 'quasar'
export default {
  data(){
    return{

      dato:{fechanac:date.formatDate(Date.now(),'YYYY-MM-DD')},
      columns:[
        {label:'ci',name:'ci',field:'ci',align:'center'},
        {label:'nombre',name:'nombre',field:'nombre',align:'left'},
        {label:'apellido',name:'apellido',field:'apellido',align:'left'},
        {label:'fechanac',name:'fechanac',field:'fechanac',align:'center'},
        // {label:'direccion',name:'direccion',field:'direccion',align:'center'},
        {label:'celular',name:'celular',field:'celular',align:'center'},
        // {label:'foto',name:'foto',field:'foto',align:'center'},
        {label:'saldo',name:'saldo',field:'saldo',align:'center'},
        {label:'codigo',name:'codigo',field:'codigo',align:'center'},
        {label:'recargar',name:'recargar',field:'recargar',align:'center'},
        // {label:'fecha',name:'fecha',field:'fecha',align:'center'},
      ],
      clientes:[],
      cliente:{},
      filter:'',
      boolrecarga:false,
      recarga:'',
    }
  },
  created(){
    this.misdatos()
  },
  methods:{
    guardarrecarga(){
      this.$q.loading.show()
      this.$axios.put(process.env.API+'/cliente/'+this.cliente.id,{cliente_id:this.cliente.id,monto:this.recarga}).then(res=>{
        this.misdatos()
        this.boolrecarga=false
        // this.cliente={}
        this.recarga=''
        let myWindow = window.open("", "Imprimir", "width=200,height=100");
        myWindow.document.write(res.data);
        myWindow.document.close();
        myWindow.focus();
        setTimeout(function(){
          myWindow.print();
          myWindow.close();
          // this.comanda(sale_id);
          //    impAniv(response);
        },500);
        // console.log(res.data)
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    crear(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/cliente',this.dato).then(res=>{
        this.misdatos()
        this.cliente={}
        // console.log(res.data)
      }).catch(err=>{
        this.$q.loading.hide()
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    showrecarga(cliente){
      this.cliente=cliente
      this.boolrecarga=true
    },
    misdatos(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/cliente').then(res=>{
        this.clientes=res.data
        // console.log(this.clientes)
        this.$q.loading.hide()
      })
    }
  }
}
</script>

<style scoped>

</style>
