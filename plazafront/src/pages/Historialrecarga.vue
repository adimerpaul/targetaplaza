<template>
<q-page class="q-pa-xs">
  <div class=" responsive">
    <table id="example" class="display" style="width:100%">
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
      <tr v-for="fila in filas" :key="fila">
        <td>{{fila.num}}</td>
        <td>{{fila.fecha}}</td>
        <td>{{fila.hora}}</td>
        <td>{{fila.monto}}</td>
        <td>{{fila.nombre}} </td>
        <td>{{fila.usuario}}</td>
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
      this.filas=[]
      this.$axios.get(process.env.API+'/recarga').then( res=>{
        // console.log(res.data);
        let num=0
        res.data.forEach(r => {
          num++
            r.num=num
            r.usuario=r.user.name
            r.nombre=r.cliente.nombre +' ' + r.cliente.apellido
            this.filas.push(r)
        });
        
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
          this.$q.loading.hide();
        this.$q.notify({
          message:err.message,
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
