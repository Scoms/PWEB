(* Projet IAP1 : Quadtrees *)

(* Paiva Christophe *)

type quadrant = NO | NE | SO | SE
type rect = {top : int; bottom : int; left : int; right : int};;
type point = {x : int; y : int};;

type pquadtree =  PEmpty
		| PNoeud of point*rect*pquadtree*pquadtree*pquadtree*pquadtree;;

let n = 9;;

(* interface puissance2
	type		int -> int = <fun>
	argument	n : un entier indiquant la puissance de 2 souhaite
	pre		n doit etre positif
	post		la puissance de 2 au rang n
*)

let rec puissance2 n = match n with
  0 -> 1
| 1 -> 2
| n -> 2 * puissance2 (n - 1);;

let tailleFeuille = puissance2 n;;
				
let feuille = {top = tailleFeuille; bottom = 0; left = 0; right = tailleFeuille};;

(* interface pointEquals
	type		point -> point -> bool = <fun>
	argument	pt1 : un point
			pt2 : un point
	pre		pt1 et pt2 doivent etre des points bien formes
	post		true si pt1 est egal a pt2 false sinon
*)

let pointEquals pt1 pt2 = if (pt1.x = pt2.x)
				then if (pt1.y = pt2.y)
					then true
					else false
				else false;;

(* interface quelQuadrant
	type		rect -> point -> quadrant = <fun>
	argument	r : un rect
			pt : un point
	pre		pt un point bien forme et r un rect bien forme
	post		renvoie le quadrant auquel appartient le point 
			entre NO, NE, SO et SE
*)
							
let quelQuadrant r pt = let milieuX = ((r.right - r.left) / 2) + r.left in
			let milieuY = ((r.top - r.bottom) / 2) + r.bottom in
			if (pt.x < milieuX && pt.x > r.left)
			then if (pt.y < milieuY && pt.y > r.bottom)
				then SO
				else if (pt.y < r.top)
					then NO
					else failwith "point trop haut ou trop bas"
			else if (pt.x < r.right)
				then if (pt.y < milieuY && pt.y > r.bottom)
					then SE
					else if (pt.y < r.top)
						then NE
						else failwith "point trop haut ou trop bas"
				else failwith "point trop a droite ou a gauche";;
		
(* Question 1 *)
		
(* interface pappartient
	type		point -> pquadtree -> bool = <fun>
	argument	pt : un point
			pquad : un pquadtree
	pre		pt un point bien forme et pquad un pquadtree bien forme
	post		true si le point pt appartient a l'ensemble des points du
			pquadtree pquad, false sinon
*)
		
let rec pappartient pt pquad = match pquad with
  PEmpty -> false
| PNoeud (p, r, nordOuest, nordEst, sudOuest, sudEst) ->
			if (pointEquals pt p)
			then true
			else match quelQuadrant r pt with
				  NO -> pappartient pt nordOuest
				| NE -> pappartient pt nordEst
				| SO -> pappartient pt sudOuest
				| SE -> pappartient pt sudEst;;
		
(* Question 2 *)
		
(* interface pchemin
	type		point -> pquadtree -> quadrant list = <fun>
	argument	pt : un point
			pquad : un pquadtree
	pre		pt un point bien forme et pquad un pquadtree bien forme
	post		une liste de quadrant indiquant tous les quadrants par lesquelles
			il faut passer pour arriver dans celui ou est present le point pt
			dans le pquadtree pquad si le point est present dans celui-ci
*)
				
let rec pchemin pt pquad = match pquad with
  PEmpty -> failwith "Le point n'est pas present"
| PNoeud (p, r, nordOuest, nordEst, sudOuest, sudEst) ->
			if (pointEquals pt p)
			then [quelQuadrant r pt]
			else match quelQuadrant r pt with
				  NO -> NO::pchemin pt nordOuest
				| NE -> NE::pchemin pt nordEst
				| SO -> SO::pchemin pt sudOuest
				| SE -> SE::pchemin pt sudEst;;
				
(* interface creerRectangle
	type		rect -> quadrant -> rect = <fun>
	argument	rprec : un rectangle
			quad : un quadrant
	pre		rprec un rect bien forme et quad un quadrant
	post		creer un nouveau rect qui est le quadrant quad du rect rprec
*)
				
let creerRectangle rprec quad = match quad with
  NO -> {top = rprec.top;
		bottom = ((rprec.top - rprec.bottom) / 2) + rprec.bottom;
		left = rprec.left;
		right = ((rprec.right - rprec.left) / 2) + rprec.left}
| NE -> {top = rprec.top;
		bottom = ((rprec.top - rprec.bottom) / 2) + rprec.bottom;
		left = ((rprec.right - rprec.left) / 2) + rprec.left;
		right = rprec.right}
| SO -> {top = ((rprec.top - rprec.bottom) / 2) + rprec.bottom;
		bottom = rprec.bottom;
		left = rprec.left;
		right = ((rprec.right - rprec.left) / 2) + rprec.left}
| SE -> {top = ((rprec.top - rprec.bottom) / 2) + rprec.bottom;
		bottom = rprec.bottom;
		left = ((rprec.right - rprec.left) / 2) + rprec.left;
		right = rprec.right};;
		
(* interface inserePremier
	type		point -> pquadtree = <fun>
	argument	pt : un point
	pre		pt doit etre le tout premier point a inserer dans notre feuille
	post		le premier pquadtree contenant le premier point pt et la feuille
			comme rect
*)

let inserePremier pt = PNoeud (pt, feuille, PEmpty, PEmpty, PEmpty, PEmpty);;
				
(* interface insereVide
	type		point -> rect -> pquadtree = <fun>
	argument	pt : un point
			rprec : un rect
	pre		rprec doit etre le rect du pquadtree non vide precedent, car il
			faut creer le rect pour le pquadtree du cadrant vide ou le point
			est present.
	post		un pquadtree contenant le point et sa nouvelle surface rect.
*)
				
let insereVide pt rprec = let r = creerRectangle (rprec) (quelQuadrant rprec pt)
in PNoeud (pt, r, PEmpty, PEmpty, PEmpty, PEmpty);;

(* interface insere2
	type		point -> pquadtree -> rect -> pquadtree = <fun>
	argument	pt : un point
			pquad : un pquadtree
			rprec : un rect du pquadtree contenant pquad
	pre		pquad ne doit pas etre le premier pquadtree, il faut au moins un
			pquadtree contenant celui-ci pour avoir rprec qui est le rect
			du pquadtree precedent
	post		un pquadtree qui est pquad dont nous avons ajoute le point selon
			les regles d'insertion d'un point dans un pquadtree
*)

let rec insere2 pt pquad rprec = match pquad with
  PEmpty -> insereVide pt rprec
| PNoeud (pt2, r, nordOuest, nordEst, sudOuest, sudEst) ->
	if (pointEquals pt pt2)
	then pquad
	else match quelQuadrant r pt with
		  NO -> PNoeud (pt2, r, insere2 pt nordOuest r, nordEst, sudOuest, sudEst)
		| NE -> PNoeud (pt2, r, nordOuest, insere2 pt nordEst r, sudOuest, sudEst)
		| SO -> PNoeud (pt2, r, nordOuest, nordEst, insere2 pt sudOuest r, sudEst)
		| SE -> PNoeud (pt2, r, nordOuest, nordEst, sudOuest, insere2 pt sudEst r);;

(* Question 3 *)
		
(* interface insere
	type		point -> pquadtree -> pquadtree = <fun>
	argument	pt : le point a inserer
			pquad : le pquadtree ou il faut inserer le point
	pre		rien de specifique
	post		un pquadtree qui est pquad dont nous avons ajoute le point selon
			les regles d'insertion d'un point dans un pquadtree
*)
	
let insere pt pquad = match pquad with
  PEmpty -> inserePremier pt
| PNoeud (pt2, r, nordOuest, nordEst, sudOuest, sudEst) ->
	if (pointEquals pt pt2)
	then pquad
	else match quelQuadrant r pt with
		  NO -> PNoeud (pt2, r, insere2 pt nordOuest r, nordEst, sudOuest, sudEst)
		| NE -> PNoeud (pt2, r, nordOuest, insere2 pt nordEst r, sudOuest, sudEst)
		| SO -> PNoeud (pt2, r, nordOuest, nordEst, insere2 pt sudOuest r, sudEst)
		| SE -> PNoeud (pt2, r, nordOuest, nordEst, sudOuest, insere2 pt sudEst r);;
		
(* Question 4 *)

let pt1 = {x = 40; y = 321};;
let pt2 = {x = 500; y = 400};;
let pt3 = {x = 296; y = 472};;
let pt4 = {x = 499; y = 4};;

let pquadVide = PEmpty;;

(* 1er test *)

let p = insere pt1 pquadVide;;
(* 
val p : pquadtree =
  PNoeud ({x = 40; y = 321}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty, PEmpty, PEmpty, PEmpty)
*)

let p = insere pt2 p;;
(*
val p : pquadtree =
  PNoeud ({x = 40; y = 321}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty,
   PNoeud ({x = 500; y = 400},
    {top = 512; bottom = 256; left = 256; right = 512}, PEmpty, PEmpty,
    PEmpty, PEmpty),
   PEmpty, PEmpty)
*)

let p = insere pt3 p;;
(*
val p : pquadtree =
  PNoeud ({x = 40; y = 321}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty,
   PNoeud ({x = 500; y = 400},
    {top = 512; bottom = 256; left = 256; right = 512},
    PNoeud ({x = 296; y = 472},
     {top = 512; bottom = 384; left = 256; right = 384}, PEmpty, PEmpty,
     PEmpty, PEmpty),
    PEmpty, PEmpty, PEmpty),
   PEmpty, PEmpty)
*)

let p = insere pt4 p;;
(*
val p : pquadtree =
  PNoeud ({x = 40; y = 321}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty,
   PNoeud ({x = 500; y = 400},
    {top = 512; bottom = 256; left = 256; right = 512},
    PNoeud ({x = 296; y = 472},
     {top = 512; bottom = 384; left = 256; right = 384}, PEmpty, PEmpty,
     PEmpty, PEmpty),
    PEmpty, PEmpty, PEmpty),
   PEmpty,
   PNoeud ({x = 499; y = 4},
    {top = 256; bottom = 0; left = 256; right = 512}, PEmpty, PEmpty, PEmpty,
    PEmpty))
*)

(* 2eme test *)

let p' = insere pt4 pquadVide;;
(*
val p' : pquadtree =
  PNoeud ({x = 499; y = 4}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty, PEmpty, PEmpty, PEmpty)
*)

let p' = insere pt3 p';;
(*
val p' : pquadtree =
  PNoeud ({x = 499; y = 4}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty,
   PNoeud ({x = 296; y = 472},
    {top = 512; bottom = 256; left = 256; right = 512}, PEmpty, PEmpty,
    PEmpty, PEmpty),
   PEmpty, PEmpty)
*)

let p' = insere pt2 p';;
(*
val p' : pquadtree =
  PNoeud ({x = 499; y = 4}, {top = 512; bottom = 0; left = 0; right = 512},
   PEmpty,
   PNoeud ({x = 296; y = 472},
    {top = 512; bottom = 256; left = 256; right = 512}, PEmpty,
    PNoeud ({x = 500; y = 400},
     {top = 512; bottom = 384; left = 384; right = 512}, PEmpty, PEmpty,
     PEmpty, PEmpty),
    PEmpty, PEmpty),
   PEmpty, PEmpty)
*)

let p' = insere pt1 p';;
(*
val p' : pquadtree =
  PNoeud ({x = 499; y = 4}, {top = 512; bottom = 0; left = 0; right = 512},
   PNoeud ({x = 40; y = 321},
    {top = 512; bottom = 256; left = 0; right = 256}, PEmpty, PEmpty, PEmpty,
    PEmpty),
   PNoeud ({x = 296; y = 472},
    {top = 512; bottom = 256; left = 256; right = 512}, PEmpty,
    PNoeud ({x = 500; y = 400},
     {top = 512; bottom = 384; left = 384; right = 512}, PEmpty, PEmpty,
     PEmpty, PEmpty),
    PEmpty, PEmpty),
   PEmpty, PEmpty)
*)

(* Question 5 *)

#load "graphics.cma";;
let size = string_of_int (tailleFeuille + 50) in Graphics.open_graph (" " ^ size ^ "x" ^ size);;
Graphics.set_window_title "Projet";;
Graphics.resize_window tailleFeuille tailleFeuille;;
Graphics.draw_rect 0 0 tailleFeuille tailleFeuille;;

(* interface dessinQuadrant
	type		rect -> unit = <fun>
	argument	rect : la surface ou il faut afficher les 4 quadrants
	pre		rect un rectangle bien fait,
			avec la valeur de left < la valeur de right
			et la valeur de bottom < la valeur de top
	post		un dessin avec les quatre quadrants dessines
*)

let dessinQuadrant r = let largeur = (r.right - r.left) / 2 in
			let hauteur = (r.top - r.bottom) / 2 in
			let origineX = r.left and origineY = r.bottom in
			let origineX2 = origineX + largeur in
			let origineY2 = origineY + hauteur in
			Graphics.draw_rect origineX origineY largeur hauteur;
			Graphics.draw_rect origineX2 origineY largeur hauteur;
			Graphics.draw_rect origineX origineY2 largeur hauteur;
			Graphics.draw_rect origineX2 origineY2 largeur hauteur;;
						
(* interface dessinPquad
	type		pquadtree -> unit = <fun>
	argument	pquad : le pquadtree qu'il faut dessiner
	pre			
	post		un dessin de tout le pquadtree pquad
*)
						
let rec dessinPquad pquad = match pquad with
  PEmpty -> Graphics.moveto 0 0
| PNoeud (pt, r, nordOuest, nordEst, sudOuest, sudEst) -> 
					dessinQuadrant r;
					Graphics.draw_circle pt.x pt.y 1;
					Graphics.moveto pt.x pt.y;
					Graphics.draw_string "Pnt";
					dessinPquad nordOuest;
					dessinPquad nordEst;
					dessinPquad sudOuest;
					dessinPquad sudEst;;
					
(* Question 6 *)

type couleur = Blanc | Noir;;

type rquadtree = Uni of couleur
		| RQ of rquadtree*rquadtree*rquadtree*rquadtree;;
				
let rqn = Uni Noir;;
let rqb = Uni Blanc;;

let rq1 = RQ (rqn, rqb, rqn, rqb);;
let rq2 = RQ (rqb, rqn, rqb, rqn);;
let rq3 = RQ (RQ (rqn, rqn, rqb, rqb), rqn, rqb, RQ(rqb, rqb, rqn, rqn));;
let rq4 = RQ (rqn, RQ (rqb, rqn, RQ (rqb, rqb, rqn, rqb), rqn), rqb, RQ (rqb, rqn ,rqb, rqn));;
let rq5 = RQ (rqn, rqb, rqb, RQ (rqb, rqn, rqb, rqn));;
				
(* interface transcriptionCouleurColor
	type		couleur -> unit = <fun>
	argument	c : une couleur
	pre			
	post		Affecte la couleur c comme couleur de dessin
*)
				
let transcriptionCouleurColor c = match c with
  Blanc -> Graphics.set_color Graphics.white
| Noir -> Graphics.set_color Graphics.black;;
				
(* interface remplirSupport
	type		rect -> couleur -> unit = <fun>
	argument	r : le rectangle a colorier
			c : la couleur a appliquer
	pre		r un rect bien forme
	post		le coloriage du rectangle rect dans la couleur c
*)
				
let remplirSupport r c = let largeur = (r.right - r.left) in
			let hauteur = (r.top - r.bottom) in
			let origineX = r.left and origineY = r.bottom in
			if c = Blanc
			then (transcriptionCouleurColor Noir;
			Graphics.draw_rect origineX origineY largeur hauteur)
			else (transcriptionCouleurColor c;
			Graphics.fill_rect origineX origineY largeur hauteur);;
				
(* interface dessinRquad
	type		rquadtree -> rect -> unit = <fun>
	argument	rquad : un rquadtree
			r : le support du rquadtree rquad
	pre		r un rect bien forme
	post		le dessin du rquadtree rquad
*)
				
let rec dessinRquad rquad r = match rquad with
  Uni c -> remplirSupport r c
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
	let milieuX = ((r.right - r.left) / 2) + r.left in
	let milieuY = ((r.top - r.bottom) / 2) + r.bottom in
	let rno = {top = r.top; bottom = milieuY; left = r.left; right = milieuX} in
	let rne = {top = r.top; bottom = milieuY; left = milieuX; right = r.right} in
	let rso = {top = milieuY; bottom = r.bottom; left = r.left; right = milieuX} in
	let rse = {top = milieuY; bottom = r.bottom; left = milieuX; right = r.right} in
	dessinRquad nordOuest rno;
	dessinRquad nordEst rne;
	dessinRquad sudOuest rso;
	dessinRquad sudEst rse;;

(* Question 7 *)

(* interface inverseCouleur
	type		couleur -> couleur = <fun>
	argument	c : la couleur en entree
	pre		c une couleur dont nous avons defini un inverse
	post		l'inverse de la couleur c, dans notre cas le noir en blanc et
			le blanc en noir
*)

let inverseCouleur c = match c with
  Blanc -> Uni Noir
| Noir -> Uni Blanc;;

(* interface inverseVideo
	type		rquadtree -> rquadtree = <fun>
	argument	rquad : le rquadtree dont il faut inverser les couleurs
	pre			
	post		un rquadtree dont toutes les couleurs sont inversees
*)

let rec inverseVideo rquad = match rquad with
  Uni c -> inverseCouleur c
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
		RQ (inverseVideo nordOuest, inverseVideo nordEst, 
		inverseVideo sudOuest, inverseVideo sudEst);;
		
(* Question 8 *)

(* interface simplificationRquadtreeSansRec
	type		rquadtree -> rquadtree = <fun>
	argument	rquad : le rquadtree a simplifier
	pre
	post		un rquadtree simplifie, si il ne contient que des quadrants blanc
			on obtient un rquadtree Uni Blanc, de meme pour les autres couleurs
*)

let simplificationRquadtreeSansRec rquad = match rquad with
  Uni _ -> rquad
| RQ (Uni c1, Uni c2, Uni c3, Uni c4) -> (match c1, c2, c3, c4 with
					  Blanc, Blanc, Blanc, Blanc -> Uni Blanc
					| Noir, Noir, Noir, Noir -> Uni Noir
					| _ -> rquad)
| _ -> rquad;;

(* interface simplificationRquadtree
	type		rquadtree -> rquadtree = <fun>
	argument	rquad : le rquadtree a simplifier
	pre
	post		un rquadtree simplifie, si il ne contient que des quadrants blanc
			on obtient un rquadtree Uni Blanc, de meme pour les autres couleurs
*)

let rec simplificationRquadtree rquad = match rquad with
  Uni _ -> rquad
| RQ (Uni c1, Uni c2, Uni c3, Uni c4) -> (match c1, c2, c3, c4 with
					  Blanc, Blanc, Blanc, Blanc -> Uni Blanc
					| Noir, Noir, Noir, Noir -> Uni Noir
					| _ -> rquad)
| RQ (nordOuest, nordEst, sudOuest, sudEst) -> 
		let simpNO = simplificationRquadtree nordOuest in
		let simpNE = simplificationRquadtree nordEst in
		let simpSO = simplificationRquadtree sudOuest in
		let simpSE = simplificationRquadtree sudEst in
		simplificationRquadtreeSansRec (RQ (simpNO, simpNE, simpSO, simpSE));;

(* interface intersection
	type		rquadtree -> rquadtree -> rquadtree = <fun>
	argument	rquad1 : un rquadtree
			rquad2 : un rquadtree
	pre			
	post		un rquadtree dont les rectangles noirs communs au deux rquadtrees
			en entree apparaissent.
*)

let rec intersection rquad1 rquad2 = match rquad1, rquad2 with
  Uni c1, Uni c2 -> (match c1, c2 with
				  Noir, Noir -> Uni Noir
				| Blanc, Noir -> Uni Blanc
				| Noir, Blanc -> Uni Blanc
				| Blanc, Blanc -> Uni Blanc)
| RQ (_, _, _, _), Uni c -> if c = Noir
				then rquad1
				else Uni Blanc
| Uni c, RQ (_, _, _, _) -> if c = Noir
				then rquad2
				else Uni Blanc
| RQ (nordOuest1, nordEst1, sudOuest1, sudEst1),
  RQ (nordOuest2, nordEst2, sudOuest2, sudEst2) ->
		let rqre = RQ (intersection nordOuest1 nordOuest2, 
		intersection nordEst1 nordEst2, 
		intersection sudOuest1 sudOuest2, 
		intersection sudEst1 sudEst2) in simplificationRquadtree rqre;;
							
(* Question 9 *)

(* interface union
	type		rquadtree -> rquadtree -> rquadtree = <fun>
	argument	rquad1 : un rquadtree
			rquad2 : un rquadtree
	pre			
	post		un rquadtree dont les rectangles noirs apparaissant dans l'un
			ou l'autre rquadtree en entree apparaissent.
*)

let rec union rquad1 rquad2 = match rquad1, rquad2 with
  Uni c1, Uni c2 -> (match c1, c2 with
			  Noir, Noir -> Uni Noir
			| Blanc, Noir -> Uni Noir
			| Noir, Blanc -> Uni Noir
			| Blanc, Blanc -> Uni Blanc)
| RQ (_, _, _, _), Uni c -> (match c with
				  Noir -> Uni Noir
				| Blanc -> rquad1)
| Uni c, RQ (_, _, _, _) -> (match c with
				  Noir -> Uni Noir
				| Blanc -> rquad2)
| RQ (nordOuest1, nordEst1, sudOuest1, sudEst1),
  RQ (nordOuest2, nordEst2, sudOuest2, sudEst2) ->
	let rqre = RQ (union nordOuest1 nordOuest2, 
	union nordEst1 nordEst2, 
	union sudOuest1 sudOuest2, 
	union sudEst1 sudEst2) in simplificationRquadtree rqre;;

let rq1u2 = union rq1 rq2;;
let rq1e2 = intersection rq1 rq2;;

(* Question 10 *)

(* interface symetrieHorizontale
	type		rquadtree -> rquadtree = <fun>
	argument	rquad : un rquadtree
	pre
	post		un rquadtree qui est la symetrie du rquadtree en entree par rapport
			a l'horizontale, c'est le sud qui est le symetrique du nord.
*)

let rec symetrieHorizontaleBas rquad = match rquad with
  Uni _ -> rquad
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
		let noSym = symetrieHorizontaleBas nordOuest in
		let neSym = symetrieHorizontaleBas nordEst in
		let soSym = symetrieHorizontaleBas sudOuest in
		let seSym = symetrieHorizontaleBas sudEst in
		RQ (soSym, seSym, noSym, neSym);;

let rec symetrieHorizontale rquad = match rquad with
  Uni _ -> rquad
| RQ (nordOuest, nordEst, sudOuest, sudEst) -> 
		let noSym = symetrieHorizontaleBas nordOuest in
		let neSym = symetrieHorizontaleBas nordEst in
		simplificationRquadtree (RQ (nordOuest, nordEst, noSym, neSym));;
	
(* interface symetrieVerticale
	type		rquadtree -> rquadtree = <fun>
	argument	rquad : un rquadtree
	pre
	post		un rquadtree qui est la symetrie du rquadtree en entree par rapport
			a la verticale, c'est l'est qui est le symetrique de l'ouest.
*)

let rec symetrieVerticaleDroite rquad = match rquad with
  Uni _ -> rquad
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
		let noSym = symetrieVerticaleDroite nordOuest in
		let neSym = symetrieVerticaleDroite nordEst in
		let soSym = symetrieVerticaleDroite sudOuest in
		let seSym = symetrieVerticaleDroite sudEst in
		RQ (neSym, noSym, seSym, soSym);;
	
let symetrieVerticale rquad = match rquad with
  Uni _ -> rquad
| RQ (nordOuest, nordEst, sudOuest, sudEst) -> 
		let noSym = symetrieVerticaleDroite nordOuest in
		let soSym = symetrieVerticaleDroite sudOuest in
		simplificationRquadtree (RQ (nordOuest, noSym, sudOuest, soSym));;
			
(* Question 11 *)

type bit = Zero | Un;;

(* interface quelleCouleurInt
	type		couleur -> int = <fun>
	argument	c : une couleur
	pre
	post		un entier representant la couleur passer en parametre
*)

let quelleCouleurInt c = match c with
  Blanc -> 0
| Noir -> 1;;

(* interface codageRquadtreeInt
	type		rquadtree -> int List = <fun>
	argument	rquad : un rquadtree
	pre
	post		une liste d'entier representant le rquadtree en parametre
				un 0 represente un noeud, un 1 une surface uni
				apres chaque 1 il y a le numero de la couleur 
				correspondant a la couleur de la surface uni.
*)

let rec codageRquadtreeInt rquad = match rquad with
  Uni c -> [1; quelleCouleurInt c]
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
			(0::(codageRquadtreeInt nordOuest)@(codageRquadtreeInt nordEst)
			@(codageRquadtreeInt sudOuest)@(codageRquadtreeInt sudEst));;

(* interface quelleCouleurBit
	type		couleur -> bit = <fun>
	argument	c : une couleur
	pre
	post		un bit representant la couleur passee en parametre
*)
			
let quelleCouleurBit c = match c with
  Blanc -> Zero
| Noir -> Un;;

(* interface codageRquadtreeBit
	type		rquadtree -> bit List = <fun>
	argument	rquad : un rquadtree
	pre
	post		une liste de bit representant le rquadtree en parametre
			un Zero represente un noeud, un Un une surface uni
			apres chaque Un il y a le bit de la couleur correspondant
			a la couleur de la surface uni.
*)

let rec codageRquadtreeBit rquad = match rquad with
  Uni c -> [Un; quelleCouleurBit c]
| RQ (nordOuest, nordEst, sudOuest, sudEst) ->
	(Zero::(codageRquadtreeBit nordOuest)@(codageRquadtreeBit nordEst)
	@(codageRquadtreeBit sudOuest)@(codageRquadtreeBit sudEst));;

(* Question 12 *)

(* interface quelleIntCouleurInt
	type		int -> couleur = <fun>
	argument	i : un entier
	pre		i doit etre un entier representant une couleur
	post		la couleur correspondant a l'entier passe en parametre
*)

let quelleIntCouleurInt i = match i with
  0 -> Blanc
| 1 -> Noir
| _ -> failwith "pas de couleur associe";;

(* interface possibleDecodage
	type		int -> bool = <fun>
	argument	ne : un entier representant le nombre d'element d'une liste
				representant un rquadtree
	pre			
	post		true si la longueur de la liste peut correspondre
			a un rquadtree, false sinon.
*)

let possibleDecodage ne = if ((ne - 2) mod 7) = 0
					then true
					else false;;

(* interface decodageSousRquadtreeInt
	type		int list -> rquadtree * int list = <fun>
	argument	lirq : un liste d'entier representant un rquadtree dans un autre
	pre		lirq ne doit pas representer le premier rquadtree
	post		un couple compose du ou des sous rquadtree et du rests de la
			liste d'entier.
*)
							
let rec decodageSousRquadtreeInt lirq = 
	let fste = List.hd lirq in
	(match fste with
	  1 -> (let lirqRest = (List.tl lirq) in
		let couleur = (quelleIntCouleurInt (List.hd lirqRest)) in
		(Uni couleur, List.tl lirqRest))
	| 0 -> (let lirqRest = (List.tl lirq) in
		let (ssrquad1, restli1) = (decodageSousRquadtreeInt lirqRest) in
		let (ssrquad2, restli2) = (decodageSousRquadtreeInt restli1) in
		let (ssrquad3, restli3) = (decodageSousRquadtreeInt restli2) in
		let (ssrquad4, restli4) = (decodageSousRquadtreeInt restli3) in
		(RQ (ssrquad1, ssrquad2, ssrquad3, ssrquad4), restli4))
	| _ -> failwith "liste mal formee");;	
				
(* interface decodageRquadtreeInt
	type		int list -> rquadtree = <fun>
	argument	lirq : une liste d'entier representant un rquadtree code
	pre		lirq doit etre bien formee
	post		un rquadtree qui est represente par la liste d'entier entree
			en parametre.
*)
				
let decodageRquadtreeInt lirq = 
	let ne = (List.length lirq) in
	if possibleDecodage ne
	then (let fste = List.hd lirq in
		(match fste with
		  1 -> (let lirqRest = (List.tl lirq) in
			let couleur = (quelleIntCouleurInt (List.hd lirqRest)) in
			Uni couleur)
		| 0 -> (let lirqRest = (List.tl lirq) in
			let (ssrquad1, restli1) = (decodageSousRquadtreeInt lirqRest) in
			let (ssrquad2, restli2) = (decodageSousRquadtreeInt restli1) in
			let (ssrquad3, restli3) = (decodageSousRquadtreeInt restli2) in
			let (ssrquad4, restli4) = (decodageSousRquadtreeInt restli3) in
			if restli4 = []
			then (RQ (ssrquad1, ssrquad2, ssrquad3, ssrquad4))
			else failwith "erreur raisonnement")
		| _ -> failwith "liste mal formee"))
	else failwith "liste mal formee";;
									
(* interface quelleIntCouleurBit
	type		bit -> couleur = <fun>
	argument	i : un bit
	pre		i doit etre un bit representant une couleur
	post		la couleur correspondant au bit passe en parametre
*)

let quelleIntCouleurBit i = match i with
  Zero -> Blanc
| Un -> Noir;;
									
(* interface decodageSousRquadtreeBit
	type		bit list -> rquadtree * bit list = <fun>
	argument	lirq : un liste de bit representant un rquadtree dans un autre
	pre		lirq ne doit pas representer le premier rquadtree
	post		un couple compose du sous rquadtree et du rest de la
			liste de bit.
*)
							
let rec decodageSousRquadtreeBit lirq = 
	let fste = List.hd lirq in
	(match fste with
	  Un -> (let lirqRest = (List.tl lirq) in
		let couleur = (quelleIntCouleurBit (List.hd lirqRest)) in
		(Uni couleur, List.tl lirqRest))
	| Zero -> (let lirqRest = (List.tl lirq) in
		let (ssrquad1, restli1) = (decodageSousRquadtreeBit lirqRest) in
		let (ssrquad2, restli2) = (decodageSousRquadtreeBit restli1) in
		let (ssrquad3, restli3) = (decodageSousRquadtreeBit restli2) in
		let (ssrquad4, restli4) = (decodageSousRquadtreeBit restli3) in
		(RQ (ssrquad1, ssrquad2, ssrquad3, ssrquad4), restli4)));;	
				
(* interface decodageRquadtreeBit
	type		bit list -> rquadtree = <fun>
	argument	lirq : une liste de bit representant un rquadtree code
	pre		lirq doit etre bien formee
	post		un rquadtree qui est represente par la liste de bit entree
			en parametre.
*)
				
let decodageRquadtreeBit lirq = 
	let ne = (List.length lirq) in
	if possibleDecodage ne
	then (let fste = List.hd lirq in
		(match fste with
			Un -> (let lirqRest = (List.tl lirq) in
			let couleur = (quelleIntCouleurBit (List.hd lirqRest)) in
			Uni couleur)
		| Zero -> (let lirqRest = (List.tl lirq) in
			let (ssrquad1, restli1) = (decodageSousRquadtreeBit lirqRest) in
			let (ssrquad2, restli2) = (decodageSousRquadtreeBit restli1) in
			let (ssrquad3, restli3) = (decodageSousRquadtreeBit restli2) in
			let (ssrquad4, restli4) = (decodageSousRquadtreeBit restli3) in
			if restli4 = []
			then (RQ (ssrquad1, ssrquad2, ssrquad3, ssrquad4))
			else failwith "erreur raisonnement")))
	else failwith "liste mal formee";;
									
(* Question 13 *)

type quadtree = Empty
| Q of rect * (rect list) * (rect list) *
quadtree * quadtree * quadtree * quadtree;;

(* interface dessinRect
	type		rect list -> unit = <fun>
	argument	l : une liste de rectangle a dessiner
	pre			
	post		un dessin avec tous les rect presents dans la liste en entree
*)

let rec dessinRect l = match l with
  [] -> Graphics.moveto 0 0
| r::rest -> (let largeur = r.right - r.left in
		let hauteur = r.top - r.bottom in
		Graphics.draw_rect r.left r.bottom largeur hauteur;
		dessinRect rest);;

(* interface dessinQuadtree
	type		quadtree -> unit = <fun>
	argument	quad : le quadtree dont il faut faire le dessin
	pre			
	post		un dessin du quadtree passe en parametre.
*)
				
let rec dessinQuadtree quad = match quad with
  Empty -> Graphics.moveto 0 0
| Q (r, lv, lh, nordOuest, nordEst, sudOuest, sudEst) ->
		(dessinQuadrant r;
		dessinRect lv;
		dessinRect lh;
		dessinQuadtree nordOuest;
		dessinQuadtree nordEst;
		dessinQuadtree sudOuest;
		dessinQuadtree sudEst);;

(* Question 14 *)

type position = Vertical | Horizontal
| NOuest | NEst | SOuest | SEst;;

(* interface quellePosition
	type		rect -> rect -> position = <fun>
	argument	f : un rectangle qui est la feuille ou il faut tester le rectangle
			r : le rectangle dont il faut savoir sa place
	pre		f doit etre un rectangle bien forme et plus grand que r
			r doit etre un rectangle bien forme et plus petit que f
	post		l'endroit ou se trouve r dans f soit sur la mediane verticale ou
			horizontale, sinon dans quel quadrant il est.
*)

let quellePosition f r = let milieuX = ((f.right - f.left) / 2) + f.left in
		let milieuY = ((f.top - f.bottom) / 2) + f.bottom in
		if r.left < milieuX
		then (if r.right > milieuX
			then Vertical
			else (if r.bottom < milieuY
				then (if r.top > milieuY
					then Horizontal
					else SOuest)
				else NOuest))
		else (if r.bottom < milieuY
			then (if r.top > milieuY
				then Horizontal
				else SEst)
			else NEst);;

(* interface insertionRectQuadtree2
	type		quadtree -> rect -> rect -> quadtree = <fun>
	argument	quad : le quadtree dans lequel il faut inserer un rectangle
			r : le rect a inserer dans le quadtree
			rprec : le rect qui est le rectangle representant tout le 
				quadtree en entre
	pre		r et rprec des rectangles bien formes
	post		un quadtree representant le quadtree en entre et contenant 
			en plus le rectangle en entre
*)
								
let rec insertionRectQuadtree2 quad r rprec = 
			let qno = creerRectangle rprec NO in
			let qne = creerRectangle rprec NE in
			let qso = creerRectangle rprec SO in
			let qse = creerRectangle rprec SE in
	match quad with
  Empty -> 
	(match quellePosition rprec r with
	  Vertical -> Q (rprec, [r], [], 
		Empty, Empty, Empty, Empty)
	| Horizontal -> Q (rprec, [], [r], 
		Empty, Empty, Empty, Empty)
	| NOuest -> Q (rprec, [], [], 
		insertionRectQuadtree2 quad r qno, Empty, Empty, Empty)
	| NEst -> Q (rprec, [], [], Empty, 
		insertionRectQuadtree2 quad r qne, Empty, Empty)
	| SOuest -> Q (rprec, [], [], 
		Empty, Empty, insertionRectQuadtree2 quad r qso, Empty)
	| SEst -> Q (rprec, [], [], 
		Empty, Empty, Empty, insertionRectQuadtree2 quad r qse))
| Q (rectangle, lv, lh, nordOuest, nordEst, sudOuest, sudEst) ->
	(match quellePosition rectangle r with
	  Vertical -> Q (rectangle, lv@[r], lh, 
		nordOuest, nordEst, sudOuest, sudEst)
	| Horizontal -> Q (rectangle, lv, lh@[r], 
		nordOuest, nordEst, sudOuest, sudEst)
	| NOuest -> Q (rectangle, lv, lh, 
		insertionRectQuadtree2 nordOuest r qno, nordEst, sudOuest, sudEst)
	| NEst -> Q (rectangle, lv, lh, 
		nordOuest, insertionRectQuadtree2 nordEst r qne, sudOuest, sudEst)
	| SOuest -> Q (rectangle, lv, lh, 
		nordOuest, nordEst, insertionRectQuadtree2 sudOuest r qso, sudEst)
	| SEst -> Q (rectangle, lv, lh, 
		nordOuest, nordEst, sudOuest, insertionRectQuadtree2 sudEst r qse));;
								
let insertionRectQuadtree quad r = match quad with
  Empty -> insertionRectQuadtree2 quad r feuille
| Q (rectangle, _, _, _, _, _, _) -> insertionRectQuadtree2 quad r rectangle;;

(* Question 15 *)

let r1 = {top = 460; bottom = 300; left = 240; right = 290};;
let r2 = {top = 265; bottom = 220; left = 300; right = 470};;
let r3 = {top = 210; bottom = 160; left = 100; right = 220};;
let r4 = {top = 500; bottom = 475; left = 400; right = 500};;
let r5 = {top = 430; bottom = 370; left = 150; right = 250};;
let q1 = Empty;;

let q2 = insertionRectQuadtree q1 r1;;
(*
val q2 : quadtree =
  Q ({top = 512; bottom = 0; left = 0; right = 512},
   [{top = 460; bottom = 300; left = 240; right = 290}], [], Empty, Empty,
   Empty, Empty)
*)

let q2 = insertionRectQuadtree q2 r2;;
(*
val q2 : quadtree =
  Q ({top = 512; bottom = 0; left = 0; right = 512},
   [{top = 460; bottom = 300; left = 240; right = 290}],
   [{top = 265; bottom = 220; left = 300; right = 470}], Empty, Empty, Empty,
   Empty)
*)

let q2 = insertionRectQuadtree q2 r3;;
(*
val q2 : quadtree =
  Q ({top = 512; bottom = 0; left = 0; right = 512},
   [{top = 460; bottom = 300; left = 240; right = 290}],
   [{top = 265; bottom = 220; left = 300; right = 470}], Empty, Empty,
   Q ({top = 256; bottom = 0; left = 0; right = 256},
    [{top = 210; bottom = 160; left = 100; right = 220}], [], Empty, Empty,
    Empty, Empty),
   Empty)
*)

let q2 = insertionRectQuadtree q2 r4;;
(*
val q2 : quadtree =
  Q ({top = 512; bottom = 0; left = 0; right = 512},
   [{top = 460; bottom = 300; left = 240; right = 290}],
   [{top = 265; bottom = 220; left = 300; right = 470}], Empty,
   Q ({top = 512; bottom = 256; left = 256; right = 512}, [], [], Empty,
    Q ({top = 512; bottom = 384; left = 384; right = 512},
     [{top = 500; bottom = 475; left = 400; right = 500}], [], Empty, Empty,
     Empty, Empty),
    Empty, Empty),
   Q ({top = 256; bottom = 0; left = 0; right = 256},
    [{top = 210; bottom = 160; left = 100; right = 220}], [], Empty, Empty,
    Empty, Empty),
   Empty)
*)

let q2 = insertionRectQuadtree q2 r5;;
(*
val q2 : quadtree =
  Q ({top = 512; bottom = 0; left = 0; right = 512},
   [{top = 460; bottom = 300; left = 240; right = 290}],
   [{top = 265; bottom = 220; left = 300; right = 470}],
   Q ({top = 512; bottom = 256; left = 0; right = 256}, [],
    [{top = 430; bottom = 370; left = 150; right = 250}], Empty, Empty,
    Empty, Empty),
   Q ({top = 512; bottom = 256; left = 256; right = 512}, [], [], Empty,
    Q ({top = 512; bottom = 384; left = 384; right = 512},
     [{top = 500; bottom = 475; left = 400; right = 500}], [], Empty, Empty,
     Empty, Empty),
    Empty, Empty),
   Q ({top = 256; bottom = 0; left = 0; right = 256},
    [{top = 210; bottom = 160; left = 100; right = 220}], [], Empty, Empty,
    Empty, Empty),
   Empty)
*)

(* Quesstion 16 *)

(* interface appartientPointRect
	type		point -> rect -> bool = <fun>
	argument	pt : le point a rechercher
			r : le rectangle ou il faut chercher le point
	pre		r un rect bien forme
	post		true si le point appartient a r false sinon
*)

let appartientPointRect pt r = if pt.x < r.left
				then false
				else if pt.x > r.right
					then false
					else if pt.y < r.bottom
						then false
						else if pt.y > r.top
						then false
						else true;;
							
(* interface appartientListRect
	type		point -> rect list -> rect list = <fun>
	argument	pt : le point a rechercher
			pt : une liste de rect ou il faut chercher ceux qui 
			contiennent le point
	pre		pt une liste de rect bien formes
	post		une liste de rect contenant tous les rectangles qui
			contiennent le point pt et qui est issue de la liste en entree.
*)
							
let rec appartientListRect pt l = match l with
  [] -> []
| x::rest -> if appartientPointRect pt x
		then x::appartientListRect pt rest
		else appartientListRect pt rest;;

(* interface appartientPointQuadtree
	type		point -> quadtree -> rect list = <fun>
	argument	pt : le point a rechercher
			quad : le quadtree ou il faut chercher tous les rectangles
				qui contiennent le point pt
	pre
	post		une liste de rect qui contiennent le point pt
*)
				
let rec appartientPointQuadtree pt quad = match quad with
  Empty -> []
| Q (_, lv, lh, nordOuest, nordEst, sudOuest, sudEst) ->
	(appartientListRect pt lv)
	@(appartientListRect pt lh)
	@(appartientPointQuadtree pt nordOuest)
	@(appartientPointQuadtree pt nordEst)
	@(appartientPointQuadtree pt sudOuest)
	@(appartientPointQuadtree pt sudEst);;