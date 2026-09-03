/* global React, ReactDOM, TweaksPanel, useTweaks, TweakSection, TweakRadio, TweakToggle, TweakSelect */
const { useEffect } = React;

const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "heroVariant": "split",
  "showMarquee": true,
  "showStickers": true,
  "accentName": "Laranja vibrante"
}/*EDITMODE-END*/;

function NutriaTweaks() {
  const [t, setT] = useTweaks(TWEAK_DEFAULTS);

  useEffect(() => {
    document.body.setAttribute('data-hero', t.heroVariant);
  }, [t.heroVariant]);

  useEffect(() => {
    const m = document.querySelector('.nt-marquee');
    if (m) m.style.display = t.showMarquee ? '' : 'none';
  }, [t.showMarquee]);

  useEffect(() => {
    document.querySelectorAll('.nt-sticker').forEach((el) => {
      el.style.display = t.showStickers ? '' : 'none';
    });
  }, [t.showStickers]);

  return (
    <TweaksPanel title="Tweaks · NutrIA">
      <TweakSection title="Variação do Hero">
        <TweakRadio
          value={t.heroVariant}
          onChange={(v) => setT({ heroVariant: v })}
          options={[
            { value: 'split', label: 'Split · celular à direita (padrão)' },
            { value: 'centered', label: 'Centralizado · texto + celular abaixo' },
            { value: 'editorial', label: 'Editorial · hero escuro' },
          ]}
        />
      </TweakSection>

      <TweakSection title="Elementos extras">
        <TweakToggle
          label="Marquee de tags"
          value={t.showMarquee}
          onChange={(v) => setT({ showMarquee: v })}
        />
        <TweakToggle
          label="Stickers flutuantes no celular"
          value={t.showStickers}
          onChange={(v) => setT({ showStickers: v })}
        />
      </TweakSection>
    </TweaksPanel>
  );
}

const root = ReactDOM.createRoot(document.getElementById('tweakRoot'));
root.render(<NutriaTweaks />);
