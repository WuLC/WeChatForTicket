d r o p   t a b l e   i f   e x i s t s   e v e n t ;  
  
 c r e a t e   t a b l e   e v e n t  
 (  
   e v e n t i d     i n t   u n s i g n e d   p r i m a r y   k e y     n o t   n u l l     a u t o _ i n c r e m e n t ,    
   e n a m e     V a r c h a r ( 2 0 )   n o t   n u l l ,  
   s t i m e   d a t e t i m e   n o t   n u l l ,  
   a d d r e s s   v a r c h a r ( 2 0 )   n o t   n u l l ,  
   p n u m b e r     i n t   u n s i g n e d   n o t   n u l l ,  
   s q t i m e   d a t e t i m e   n o t   n u l l ,  
   e q t i m e   d a t e t i m e     n o t   n u l l ,  
   u r l   V a r c h a r ( 2 5 5 )   n o t   n u l l  
   ) E N G I N E = M y I S A M   D E F A U L T   C H A R S E T = u t f 8 ;  
  
   i n s e r t   i n t o   e v e n t ( e n a m e , s t i m e , a d d r e s s , p n u m b e r , s q t i m e , e q t i m e , u r l )    
   v a l u e s ( ' � � � � � � � � � � ' ,  
   ' 2 0 1 4 - 1 0 - 1 2   1 7 : 0 0 ' , ' � � � � � � ' , ' 5 0 ' , ' 2 0 1 4 - 1 0 - 1 1   1 7 : 0 0 ' , ' 2 0 1 4 - 1 0 - 1 1   1 7 : 0 0 : 0 0 ' , ' w w w . b a i d u . c o m ' ) ;  
  
     i n s e r t   i n t o   e v e n t ( e n a m e , s t i m e , a d d r e s s , p n u m b e r , s q t i m e , e q t i m e , u r l )    
   v a l u e s ( ' � � � � d a i ' ,  
   ' 2 0 1 4 - 1 1 - 1 5   1 7 : 0 0 ' , ' � � � � � � ' , ' 5 0 ' , ' 2 0 1 4 - 1 1 - 1 3   1 7 : 0 0 ' , ' 2 0 1 4 - 1 1 - 1 4   1 7 : 0 0 : 0 0 ' , ' w w w . b a i d u . c o m ' ) ;  
  
   i n s e r t   i n t o   e v e n t ( e n a m e , s t i m e , a d d r e s s , p n u m b e r , s q t i m e , e q t i m e , u r l )    
   v a l u e s ( ' � � � � � � � � ' ,  
   ' 2 0 1 5 - 0 1 - 1 5   1 7 : 0 0 ' , ' � � � � � � ' , ' 5 0 ' , ' 2 0 1 4 - 1 1 - 1 3   1 7 : 0 0 ' , ' 2 0 1 5 - 0 1 - 1 4   1 7 : 0 0 : 0 0 ' ,  
   ' w w w . b a i d u . c o m ' ) ; 