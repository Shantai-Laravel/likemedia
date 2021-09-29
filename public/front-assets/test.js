$('[data-jcube-clone]').each(function (){
   $this = $(this)
   for(i = 0; i < $(this).data("jcube-clone"); i++){
       console.log(i);
       $this.clone().appendTo( $($this).parent() );
   }
});

