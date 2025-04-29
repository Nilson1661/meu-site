from flask import Flask, render_template
import os

# Configuração do Flask, apontando para a pasta 'template' (no singular)
app = Flask(__name__,)

@app.route('/')
def home():
    return render_template('ondearisada.html')  # Certifique-se de que o nome do arquivo é correto

if __name__ == '__main__':
    app.run(debug=True)
