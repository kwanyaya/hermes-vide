import qrcode
import string
import random
from PIL import Image
from PIL import ImageDraw
from PIL import ImageFont

def backgroundTransparent(img):
    img = img.convert('RGBA')
    newImage = []

    for item in img.getdata():
        if item[:3] == (255,255,255):
            newImage.append((255,255,255,0))
        else:
            newImage.append(item)

    img.putdata(newImage)
    return img

def codeColor(img):
    img = img.convert('RGBA')
    newImage = []
    for item in img.getdata():
        if item[:3] == (0,0,0):
            newImage.append((255,255,255))  
        else:
            newImage.append(item)
    img.putdata(newImage)
    return img

bg = Image.open("base.png")
base_url = "https://www.hap50.com/"



for i in range(1,601):
    merged_image = Image.new("RGBA", bg.size)
    # merged_image.paste(bg, (0, 0))

    draw = ImageDraw.Draw(merged_image)
    font = ImageFont.truetype("OratorStd.otf",33)

    tag = "HAP"+str(i).rjust(3, '0')
    uid = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(3))
    uid_tail = ''.join(random.choice(string.ascii_uppercase + string.digits) for _ in range(4))


    ASCII_values = [ord(character) for character in tag]
    sum_ascii = sum(ASCII_values)
    uid = uid+"d"+str(sum_ascii)+"h"+uid_tail
    query = "?tag="+tag+"&uid="+uid

    print(uid)
    # print(uid)
    url = base_url+query

    raw_qr = qrcode.make(url)
    type(raw_qr)

    black_qr = backgroundTransparent(raw_qr)
    white_qr = codeColor(black_qr)

    qr_size = (360,360)

    black_qr = black_qr.resize(qr_size,resample=Image.NEAREST)
    white_qr = white_qr.resize(qr_size,resample=Image.NEAREST)

    _, _, _, mask = black_qr.split()

    merged_image.paste(black_qr, (140, 273), mask)
    merged_image.paste(white_qr, (780, 273), mask)

    draw.text((320,638), tag, font=font, anchor="mm", fill=(0,0,0,255))
    draw.text((960,638), tag, font=font, anchor="mm", fill=(255,255,255,255))

    merged_image.save("./merge/"+tag+".png",dpi=(300, 300))

