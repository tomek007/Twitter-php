

<?php
                if ($_SERVER['REQUEST_METHOD'] = 'POST') {
                    if (isset($_POST['signup']) && !empty($_POST['username']) && 
                            !empty($_POST['userpassword']) && !empty($_POST['emailaddress'])) {
                        $name = $_POST['username'];
                        $password = $_POST['userpassword'];
                        $email = $_POST['emailaddress'];
                        $loaduser = User::loadAllUsers($conn);
                        $users = [];
                        foreach ($loaduser as $row) {
                            $users[] = $row->getUsername();
                            $users[] = $row->getEmail();
                        }
                        $addUser = [];
                        $addUser['password'] = $password;
                        if (in_array($name, $users)) {
                            echo "<p class='alert alert-danger'>the name is alredy taken</p>";
                        } else {
                            $addUser['name'] = $name;
                        }
                        if (in_array($email, $users)) {
                            echo "<p class='alert alert-danger'>the email address is alredy taken</p>";
                        } else {
                            $addUser['email'] = $email;
                        }                    
                        
                        if (count($addUser) == 3) {
                            $newUser = new User();
                            $newUser->setEmail($email);
                            $newUser->setUsername($name);
                            $newUser->setHashedPassword($password);
                            $newUser->saveToDB($conn);
                            echo "<p class='alert alert-success'> Welcome on Twitter. Now U can Sign in</p>";
                        }
                    }
                }
                ?>

