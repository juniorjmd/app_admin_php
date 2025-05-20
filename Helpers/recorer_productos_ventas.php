
private recorridoVentas():string{
  const currencyFormatter = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' });
  let receiptHTML   = (this.tipoImpresora == 'POS')? '' :`</td><td>`  ;

  //listado de dias vendidos 
  let tr1 = ` <h5>Resumen de productos</h5><table  style="font-family: Arial, sans-serif; width: 100%;"><tr><th>PRODUCTO </th><th>CNT</th><th>TOTAL</th></tr>` ;
  let tr2 = ` <h5>Resumen de ventas</h5><table  style="font-family: Arial, sans-serif; width: 100%;"><tr><th>FECHA </th><th>CANTIDAD</th><th>TOTAL</th></tr>` ; 
   let cont = 0;
      this.resumenVenta.resumen?.forEach((lista , index) => {  
        cont++;

        receiptHTML += (this.resumenVenta.productos![index] != undefined)? ` <tr> 
        <td style="text-align: left;" >${this.resumenVenta.productos![index].nombre} </td>     
        <td style="text-align: right;" >${this.resumenVenta.productos![index].cantidad} </td>
        <td style="text-align: right;" >${currencyFormatter.format(this.resumenVenta.productos![index].total)}</td>
        </tr>   `: `<tr><td  colspan='3'></td ></tr> `;
        receiptHTML += ` <tr> 
        <td style="text-align: left;" >${lista.fecha} </td>     
        <td style="text-align: right;" >${lista.cantidad} </td>
        <td style="text-align: right;" >${currencyFormatter.format(lista.totalVendido)}</td>
        </tr>     `  ;  
      if (cont == 40){
         receiptHTML += ` <tr> <td colspan='4'></td>   </tr><tr> <td colspan='4'></td></tr></table></table></div></div><br>
         <div style="font-family: Arial, sans-serif; border: 1px solid gray;margin: 10px; border-radius: 10px; padding: 15px;">
         ${this.generateCabecera() }${this.infoRVGeneral() }<div style="text-align: left;border-top: 1px solid black;" name="detalle"> 
         <table style="font-family: Arial, sans-serif; width: 100%;"><tbody><tr><td style="width: 50%; vertical-align: top;"></td><td>   `  
          ;
        receiptHTML +=`<h5>Resumen de ventas</h5> 
                 <table  style="font-family: Arial, sans-serif; width: 100%;">
                 <tr><th>FECHA </th><th>CANTIDAD</th><th>TOTAL</th></tr>`  ;
                 cont = 0 ;  }
    }); 
  receiptHTML += `</table>`;
      
  return receiptHTML
}

private recorridoProductos():string{
  const currencyFormatter = new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP' });  
  let receiptHTML  =`<h5>Resumen de productos</h5>
  <table  style="font-family: Arial, sans-serif; width: 100%;">`;
   let cont = 0;
   receiptHTML += `<tr><th>PRODUCTO </th><th>CNT</th><th>TOTAL</th></tr>`  ;
  
      this.resumenVenta.productos?.forEach((lista) => {  
        receiptHTML += ` <tr> 
        <td style="text-align: left;" >${lista.nombre} </td>     
        <td style="text-align: right;" >${lista.cantidad} </td>
        <td style="text-align: right;" >${currencyFormatter.format(lista.total)}</td>
        </tr>  
       `;
       if (cont == 40){
        receiptHTML += ` <tr> <td colspan='3'></td>   </tr><tr> <td colspan='3'></td></tr></table></table></div></div><br>
        <div style="font-family: Arial, sans-serif; border: 1px solid gray;margin: 10px; border-radius: 10px; padding: 15px;">
        ${this.generateCabecera() }${this.infoRVGeneral() }<div style="text-align: left;border-top: 1px solid black;" name="detalle"> 
        <table style="font-family: Arial, sans-serif; width: 100%;"><tbody><tr><td style="width: 50%; vertical-align: top;"></td><td>   `  
         ;
       receiptHTML +=`<h5>Resumen de ventas</h5> 
                <table  style="font-family: Arial, sans-serif; width: 100%;">
                <tr><th>PRODUCTO </th><th>CNT</th><th>TOTAL</th></tr>`  ;
                cont = 0 ;  }   
    });
    
  receiptHTML += `</table>`
   
      
  return receiptHTML
}