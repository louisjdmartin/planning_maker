<form action="ajax/editJours.php" method="POST">
  <table>
    <tr>
      <td>
        Saisissez les jours en les séparant par le caractère ";".<br />
        Caractères autorisées: [A-Za-z0-9\/]
      </td>
    </tr>
    <tr>
      <td><textarea style='border:none;width:100%;height:200px;' name='jours'><?php
        foreach($jours as $j){
          echo "$j;";
        }
      ?></textarea></td>
    </tr>
    <tr>
      <td>
        <input type="submit" value="Enregistrer"/>
      </td>
    </tr>
  </table>

</form>
