const { createApp, ref } = Vue;

createApp({
  setup(){
    const omzet = ref(930);
    const totalOrders = ref(3);
    const products = ref(6);
    const active = ref('bestellingen');

    const orders = ref([
      { id:1, name:'Jan de Vries', contact:'jan@email.com', items:3, date:'14 okt 2025', status:'Voltooid', statusClass:'voltooid' },
      { id:2, name:'Maria Bakker', contact:'maria@email.com', items:1, date:'13 okt 2025', status:'In behandeling', statusClass:'inbehandeling' },
      { id:3, name:'Piet Jansen', contact:'piet@email.com', items:5, date:'12 okt 2025', status:'In afwachting', statusClass:'inafwachting' },
    ]);

    function view(order){
      alert('Bekijk order #' + order.id + ' (demo)');
    }

    return { omzet, totalOrders, products, orders, view, active };
  }
}).mount('#app');
