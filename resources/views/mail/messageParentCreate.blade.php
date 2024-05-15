<div style="font-family: Arial, sans-serif; color: #333; max-width: 600px; margin: 0 auto;">
    <div style="margin-top: 20px;">
        <p>Bonjour Mr/Mme <span style="font-weight: bold"> {{ $parentData['nom'] }} {{ $parentData['prenom'] }}</span></p>

        <p>Vous venez d'être ajouté en tant que parent de l'élève {{ $parentData['enfant'] }}.</p>

        <p>Vous pourrez suivre l'inscription et les résultats de vos enfants à travers l'application mobile disponible ci-dessous :</p>

        <a href="{{ $loginUrl }}" style="background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin-top: 20px; border-radius: 5px; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'">Télécharger l'application mobile</a>


        <p>Merci et à bientôt !</p>
    </div>
</div>
