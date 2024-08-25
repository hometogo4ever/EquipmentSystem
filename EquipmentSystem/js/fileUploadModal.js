import uploadFile from "./uploadFile.js";

function inputFileClick(inputFile, setFile){
    return ()=>{
        const fileBrowser = inputFile.clone();
        fileBrowser.off("change");
        fileBrowser.on("change", (e)=>{
            const targetFile = e.target.files[0];
            try{
                if(!targetFile){
                    throw new Error("no file");
                }
                if(targetFile.type !=="image/jpeg"){
                    throw new Error("not jpeg");
                }
                setFile(targetFile);
            }
            catch(e){
                console.log(e);
            }
        });
        fileBrowser.click();
    }
}

class FileUploadModal{
    constructor(container, inputFile, onFinish=null){
        this.container = container;
        this.inputFile = inputFile;
        this.onFinish = ((onFinish)=>(onFinish instanceof Function)?onFinish:()=>{})(onFinish);
        this.eqid = null;
        this.files = new Map();
    }
    
    setEqid(eqid){
        this.eqid = eqid;
        this.renderModalContent();
    }
    setFile(eqid, file){
        this.files.set(eqid, file);
        this.renderModalContent();
    }

    renderModalContent(){
        if(!this.eqid)
            return;
        const eqid = this.eqid;
        const modalContent = this.container;
        const file = this.files.get(eqid)??null;
        const onFileClick = inputFileClick(this.inputFile, (file)=>this.setFile(eqid, file));

        if(file === null){
            modalContent.children("*").remove();
            modalContent.append(
                `<label>클릭하여 사진 선택</label>`
            );
            modalContent.off("click");
            modalContent.on("click", onFileClick);
        }
        else{
            modalContent.off("click");
            modalContent.children("*").remove();
            modalContent.append(
                    `
                    <canvas class="preview"/>
                    <label>클릭하여 사진 변경</label>
                    <div class="retbutton"><button>UPLOAD</button></div>
                    `
            ).ready(
                function(){
                    const fileReader = new FileReader();
                    fileReader.onload = (e)=>{
                        const src = e.target.result;
                        const img = new Image();
                        img.onload = function(){
                            const canvas = modalContent.children("canvas")[0];
                            const context = canvas.getContext("2d");
                            context.drawImage(img, 0, 0, canvas.width, canvas.height);
                        }
                        img.src = src;
                    }
                    fileReader.readAsDataURL(file);
                }
            );
    
            modalContent.children("canvas").on("click", onFileClick);
            const messageLabel = modalContent.children("label")[0];

            const onUploadFinish = (filePath)=>this.onFinish(eqid, filePath);

            modalContent.children("div.retbutton").on("click", 
                function(){
                    uploadFile(file, {
                        onUpdate: (message)=>{
                            if(messageLabel){
                                messageLabel.textContent = message;
                            }
                        },
                        onFinish: onUploadFinish,
                        onError: (error)=>console.log(error)
                    });
                }
            )
        }
    }
}



export default FileUploadModal;