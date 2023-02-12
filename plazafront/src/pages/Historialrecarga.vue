<template>
<q-page class="q-pa-xs">
  <div class=" responsive">
    <table id="example" style="width:100%">
      <thead>
      <tr>
        <th>NRO</th>
        <th>FECHA</th>
        <th>HORA</th>
        <th>MONTO</th>
        <th>CLIENTE</th>
        <th>USUARIO</th>

      </tr>
      </thead>
      <tbody>
      <tr v-for="(fila,index) in filas" :key="index">
        <td>{{index+1}}</td>
        <td>{{fila.fecha}}</td>
        <td>{{fila.hora}}</td>
        <td>{{fila.monto}}</td>
        <td>{{fila.cliente.nombre}} {{fila.cliente.apellido}}</td>
        <td>{{fila.user.name}}</td>
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
import jszip from 'jszip/dist/jszip';
import pdfMake from 'pdfmake/build/pdfmake';
import pdfFonts from 'pdfmake/build/vfs_fonts';
pdfMake.vfs=pdfFonts.pdfMake.vfs;
window.JSZip=jszip;
export default {
  data(){
    return{
      filas:[],
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
      this.$axios.get(process.env.API+'/recarga').then( res=>{
        console.log(res.data);
        this.filas = res.data;
        $('#example').DataTable().destroy();
        this.$nextTick(()=>{
          $('#example').DataTable( {
            dom: 'Bfrtip',
            buttons: [
              'copy', 'csv', 'excel', 'pdf', 'print'
            ]
          } );
          this.$q.loading.hide();
        })
      }).catch(err=>{
        this.$q.notify({
          message:err.response.data.message,
          color:'red',
          icon:'error'
        })
      })
    }
  }
}
</script>

<style scoped>

</style>
