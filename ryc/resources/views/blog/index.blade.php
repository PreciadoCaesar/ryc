@extends('layouts.app')

@section('title', 'Blog | R&C Consulting')

@section('content')
<div class="container-blog" style="max-width: 1200px; margin: 0 auto; padding: 40px 20px;">
    <div class="blog-header" style="text-align: center; margin-bottom: 50px;">
        <h1 style="color: #03206A; font-family: 'Poppins', sans-serif; font-size: 36px; margin-bottom: 10px;">
            📝 Blog de Gestión Pública
        </h1>
        <p style="color: #4A5568; font-family: 'Poppins', sans-serif; font-size: 16px;">
            Artículos, guías y novedades sobre gestión pública y capacitación profesional
        </p>
    </div>

    <div class="blog-coming-soon" style="background: #f8f9fa; border-radius: 12px; padding: 60px 40px; text-align: center; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
        <div style="font-size: 80px; margin-bottom: 20px;">🚀</div>
        <h2 style="color: #03206A; font-family: 'Poppins', sans-serif; font-size: 28px; margin-bottom: 15px;">
            Blog en Construcción
        </h2>
        <p style="color: #4A5568; font-family: 'Poppins', sans-serif; font-size: 14px; max-width: 600px; margin: 0 auto 30px; line-height: 1.6;">
            Estamos configurando nuestro blog con <strong>TallCMS</strong> para brindarte el mejor contenido SEO-optimizado sobre gestión pública, contrataciones, presupuesto y más.
        </p>
        <div style="background: #03206A; color: white; padding: 12px 30px; border-radius: 8px; display: inline-block; font-family: 'Poppins', sans-serif; font-size: 14px;">
            Próximamente Disponible
        </div>
    </div>

    <div class="blog-features" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 50px;">
        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div style="font-size: 40px; margin-bottom: 15px;">🔍</div>
            <h3 style="color: #03206A; font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 10px;">SEO Optimizado</h3>
            <p style="color: #4A5568; font-family: 'Poppins', sans-serif; font-size: 13px; line-height: 1.6;">
                Meta tags, Open Graph, Twitter Cards y Schema.org automáticos para mejor posicionamiento.
            </p>
        </div>

        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div style="font-size: 40px; margin-bottom: 15px;">📝</div>
            <h3 style="color: #03206A; font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 10px;">Block Editor</h3>
            <p style="color: #4A5568; font-family: 'Poppins', sans-serif; font-size: 13px; line-height: 1.6;">
                Editor visual con 16+ bloques para crear contenido rico sin conocimientos técnicos.
            </p>
        </div>

        <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
            <div style="font-size: 40px; margin-bottom: 15px;">📱</div>
            <h3 style="color: #03206A; font-family: 'Poppins', sans-serif; font-size: 18px; margin-bottom: 10px;">Responsive</h3>
            <p style="color: #4A5568; font-family: 'Poppins', sans-serif; font-size: 13px; line-height: 1.6;">
                Diseño adaptable a todos los dispositivos con Tailwind CSS incluido.
            </p>
        </div>
    </div>
</div>
@endsection
