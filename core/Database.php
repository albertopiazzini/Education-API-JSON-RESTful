<?php
class Database
	{


	// connessione al database
	
	 function getConnection($config)
		{
		try
			{
			return new PDO(
                $config['connection'] . ';dbname=' . $config['name'],
                $config['username'],
                $config['password'],
                $config['options']
            );
			}
		catch(PDOException $exception)
			{
				die($exception->getMessage());

			}
		}
	}
?>