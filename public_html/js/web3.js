const web3 = new Web3(Web3.givenProvider || 'https://rinkeby.infura.io/v3/0xeB09fAbC7b416b5dB0F9FEd2A9Ece7e79705dc7E'); //AccountAddress 
const contratoABI = [{"inputs":[{"internalType":"string","name":"_apellidoNombre","type":"string"},{"internalType":"string","name":"_documentoTipoNro","type":"string"},{"internalType":"string","name":"_tallerTitulo","type":"string"},{"internalType":"string","name":"_tallerCargaHoraria","type":"string"},{"internalType":"string","name":"_tallerFecha","type":"string"}],"name":"escribirDiploma","outputs":[],"stateMutability":"nonpayable","type":"function"},{"inputs":[],"name":"leerDiploma","outputs":[{"internalType":"string","name":"","type":"string"},{"internalType":"string","name":"","type":"string"},{"internalType":"string","name":"","type":"string"},{"internalType":"string","name":"","type":"string"},{"internalType":"string","name":"","type":"string"}],"stateMutability":"view","type":"function"}];
const miContratoDireccion = "0x85891E21ec50d8ED921fc66FcF467BD3c41e7F72"; //ContractAddress

    async function obtenerBlockChain(numeroBloque) {  
        const miCuentaDireccion = web3.eth.getAccounts().then( async function(cuenta){return await cuenta[0]});
        const miContrato = new web3.eth.Contract(contratoABI, miContratoDireccion, { from: await miCuentaDireccion, });
        miContrato.defaultBlock = numeroBloque; //Estable el bloque al que accederá
        return await miContrato.methods.leerDiploma().call({ from: await miCuentaDireccion}, async function(error, campo){ });
    }

    async function registrarBlockChain(apellidoNombre, documentoTipoNro, tallerTitulo, tallerCargaHoraria, tallerFecha) {  
        const miCuentaDireccion = web3.eth.getAccounts().then( async function(cuenta){return await cuenta[0]});
        const miContrato = new web3.eth.Contract(contratoABI, miContratoDireccion, { from: await miCuentaDireccion, });
        return await miContrato.methods.escribirDiploma(apellidoNombre, documentoTipoNro, tallerTitulo, tallerCargaHoraria, tallerFecha).send({
        from: await miCuentaDireccion}, function(error, transactionHash){
        }).on('confirmation', function(confirmationNumber, receipt){ });
    }