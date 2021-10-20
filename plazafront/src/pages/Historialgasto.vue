<template>
  <q-page class="q-pa-xs">
    <div class=" responsive">
      <div class="row">
        <q-form @submit="generar">
          <q-input type="date" label="Fecha" v-model="fecha"
          lazy-rules
        :rules="[ val => val && val.length > 0 || 'Ingresar fecha']"/>
          <q-btn label="Generar" icon="send" color="green" type="submit"/>
          <q-btn label="Imprimir" icon="print" color="yellow" @click="imprimir"/>
        </q-form>

      </div>
      <table id="example" style="width:100%">
        <thead>
        <tr>
          <th>NRO</th>
          <th>FECHA</th>
          <th>HORA</th>
          <th>LUGAR</th>
          <th>MONTO</th>
          <th>NUMERO</th>
          <th>CLIENTE</th>
<!--          <th>USUARIO</th>-->

        </tr>
        </thead>
        <tbody>
        <tr v-for="(fila,index) in filas" :key="index">
          <td>{{index+1}}</td>
          <td>{{fila.fecha}}</td>
          <td>{{fila.hora}}</td>
          <td>{{fila.lugar}}</td>
          <td>{{fila.monto}}</td>
          <td>{{fila.numero}}</td>
          <td v-if="fila.cliente!=null">{{fila.cliente.nombre}} {{fila.cliente.apellido}}</td>
          <td v-else>{{fila.cliente_id}}</td>
<!--          <td>{{fila.user.name}}</td>-->
        </tr>
        </tbody>
      </table>
    </div>
  </q-page>
</template>

<script>
var $  = require( 'jquery' );
require( 'datatables.net-buttons/js/buttons.html5.js' )();
require( 'datatables.net-buttons/js/buttons.print.js' )();
require('datatables.net-buttons/js/dataTables.buttons');
require('datatables.net-dt/css/jquery.dataTables.min.css');
import print from 'datatables.net-buttons/js/buttons.print';
import {date} from 'quasar';
import jszip from 'jszip/dist/jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs=pdfFonts.pdfMake.vfs;
window.JSZip=jszip;
export default {
  data(){
    return{
      filas:[],
      fecha:date.formatDate(Date.now(),'YYYY-MM-DD'),
    }
  },
  mounted() {
    this.misdatos()
    $('#example').DataTable( {
      dom: 'Bfrtip',
      buttons: [
        'copy', 'csv', 'excel', 'pdf', 'print'
      ]
    } );
  },
  methods:{
    misdatos(){
      this.$q.loading.show()
      this.$axios.get(process.env.API+'/historial').then( res=>{
        // console.log(res.data);
        this.$q.loading.hide();
        // return false
        this.filas = res.data;
        $('#example').DataTable().destroy();
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );

        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    
    generar(){
      this.$q.loading.show()
      this.$axios.post(process.env.API+'/fhistorial',{fecha:this.fecha}).then( res=>{
        // console.log(res.data);
        this.$q.loading.hide();
        // return false
        this.filas = res.data;
        $('#example').DataTable().destroy();
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );

        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    },
    imprimir(){
      console.log(this.fecha)
      if(this.fecha!=''){
      this.$axios.post(process.env.API+'/imprimir',{fecha:this.fecha}).then( res=>{
        console.log(res.data)
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
      })

      }
    }
    
  }
  

}
</script>

<style scoped>

</style>
