</body>
    	<footer>
			<ul>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/listBillet/1">Tous Les billets</a></li>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/statistique">Statistiques</a></li>
            <li><a href="http://medias4all.livehost.fr/blog/index.php/categorie">Toutes les Categories</a></li>
            <?php if (isset($_SESSION['admin'])){	
					echo '<li><a href="http://medias4all.livehost.fr/blog/index.php/ajouterCategorie">Ajout catégorie</a></li>';
					echo '<li><a href="http://medias4all.livehost.fr/blog/index.php/listeUtilisateurs">Liste utlisateurs</a></li>';
			}
			?>
		</ul>
			<p>@Auteur Amir Harkat 2016</p>
		</footer>	
</html>
