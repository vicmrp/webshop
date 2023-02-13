# Time Schedule
### 68 days left at DTU before final exam from 01-02-2023

Release a version 1.0.0 of Finish making a version 
In order for you to make any application that can be sustainable, you need to release a version of the webframework, that your projects can rely on. Use the released version to rebuild the webshop. This means that it should be explicitly stated in the webshop project, that it is build on top of victorswebframework v1.0.0, also note version of php, apache, composer-dependencies and other relevant technology. So that it is more easily to rebuild the webshop. Make a reference to a docker image/project/git-repo that your project can run on. Once you have made and understood how to proceed with this, then you can proceed to do the same with one of your other projects that relies on the victorswebframework, maybe it is a good time to patch, and make updates to victorswebframework, before taking to use in another project.

<br> 

###  1. Build and release a production version of victorsframework that other projects can depend on.

Build another project (the webshop), and note down all relevant versioning, and safe all depencies in composer that the project depends on. victorsframework should not have any dependencies in composer. This means that the vendor folder should be empty.

### 2. After Successful Webshop Project Build
After successfully building the webshop project on top of victorswebframework, you should:
1. Go back to victorswebframework and make any necessary patches or upgrades with proper documentation in the code. 
2. Move on to the next project, TSPA2, and create a use case and requirement specification to clarify its purpose and coding requirements.
3. Deploy the TSPA2 application in a docker container, and save the docker image and build files in a Git repository hosted on Github.
4. Obtain the domain name tspa2.sustain.dtu.dk
5. Create a folder in the TSPA2 Git repository for PowerShell scripts and docs for connecting to Active Directory for user validation and determining the OU location for a computer.
6. Create a folder for the application that needs to run inside SCCM.
7. Release and deploy TSPA2.


### 3. When you have build and deployed TSPA2, you will proceed to make a usecase & requirement specification for Equip-Online.

1. Make a use case and requirement specification for Equip-Online, defining its purpose and necessary requirements for coding the application. 
2. Begin coding Equip-Online using the newly released version of victorswebframework.
3. Deploy Equip-Online in a Docker container and save the image in a Git repository on GitHub.
4. Reserve a domain name equip-online.sustain.dtu.dk.
5. Create a folder in the Equip-Online Git repository for PowerShell scripts and documents related to connecting to the active directory for user validation and determining the OU location for a computer.
6. Create a folder for the application to run within SCCM.
7. Create a release and deploy it.

### 4. Lyngby Frisbee Klub webpage. 
This page is an information page and a subscription page (where poeple can pay to become a member)



#### Regarding Artek project. I cannot proceed before Thomas Ingemann has replied my email.
